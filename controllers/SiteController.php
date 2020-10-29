<?php

namespace app\controllers;

use app\models\Cart;
use app\models\Neuron;
use app\models\Product;
use app\models\SignUp;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\VarDumper;
use yii\httpclient\Client;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use yii\web\UploadedFile;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $products = Product::find()->all();
        return $this->render('index', ['products' => $products]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * @return string|Response
     */
    public function actionAddProduct()
    {
        $model = new Product();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->img = UploadedFile::getInstance($model, 'img');
                $model->img = $model->upload();
                if ($model->save()) {
                    return $this->redirect('/');
                }

            }
        }

        return $this->render('add-product', [
            'model' => $model,
        ]);
    }

    /**
     * @return string|Response
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\httpclient\Exception
     */
    public function actionSignup()
    {
        $model = new SignUp();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $client = new Client();

            $time = time() * 1000;
//            $secret = 'FijaknwuhaKJNFDjnj2141makmd';
//            $algo = 'sha512';
//            $merchant_id = 'd1554bde-4e1f-49c9-af4f-5d16fe3e80f6';
//            $data_for_sign = [
//                'date-time' => $time,
//                'path' => '/v1/user',
//                'firstName' => $model->firstName,
//                'lastName' => $model->lastName,
//                'region' => $model->region,
//                'phone' => $model->phone,
//                'email' => $model->email,
//            ];

            $data_for_sign = [
                "date-time" => $time,
                "path" => "/v1/user",
                "firstName" => "николай",
                "lastName" => "комягин",
                "region" => "RU",
                "phone" => "+79528054699",
                "email" => "1@mail.ru"
            ];

            $response = $client->createRequest()
                ->setMethod('post')
                ->setFormat(Client::FORMAT_JSON)
                ->setUrl('https://gambling.test.i-link.pro/api/v1/user')
                ->setHeaders([
                    'date-time' => $time,
                    'MERCHANT-ID' => 'd1554bde-4e1f-49c9-af4f-5d16fe3e80f6',
                    'Content-Type' => 'application/json',
                    'HMAC-SHA512' => Neuron::getHmac($data_for_sign, 'sha512', 'FijaknwuhaKJNFDjnj2141makmd')
                ])->setData(json_encode($data_for_sign))
                ->send();

//            if ($response->isOk) {
//            VarDumper::dump($_SERVER['header'], true, 3);
            var_dump($response->data);
            die();
//            }
            $model->save();

            return $this->redirect('/');
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return string
     */
    public function actionAdd($id)
    {
        if (!Yii::$app->user->isGuest) {
            $cart = new Cart();
            $product = Product::findOne($id);
            if ($product != null) {
                $cart->user_id = Yii::$app->user->id;
                $cart->product_id = $id;
                if ($cart->save()) {
                    Yii::$app->session->setFlash('success', 'Товар добавлен в корзину');

                    return $this->redirect('/');
                }
            }
            return $this->redirect('/');
        }
        Yii::$app->session->setFlash('error', 'Вам нужно авторизироваться');

        return $this->render('login');
    }

    /**
     * @return string
     */
    public function actionCart()
    {
        $model = new Neuron();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            var_dump($model);
            die();
        }

        if (!Yii::$app->user->isGuest) {
            $products = Cart::find()->where(['user_id' => Yii::$app->user->id])->all();
            return $this->render('cart', ['products' => $products, 'model' => $model]);
        }

        Yii::$app->session->setFlash('error', 'Вам нужно авторизироваться');
        return $this->render('login');
    }

    /**
     * @param $id
     * @return Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $product = Cart::find()->where($id)->one();
        $product->delete();

        return $this->redirect('/site/cart');
    }

}
