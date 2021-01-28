<?php

namespace frontend\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\Profiles;
use common\models\ProfilesSearch;
use common\models\Restaurant;
use common\models\RestaurantSearch;
use common\models\User;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\data\Pagination;

/**
 * Site controller
 */
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
                'only' => ['logout', 'signup', 'profile'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['profile'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['get'],
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
     * @return mixed
     */
    public function actionIndex()
    {
        $latestRestaurants = Restaurant::find()->limit(4)->orderBy(['restaurantId' => SORT_DESC])->all();

        return $this->render('index', ['latestRestaurants' => $latestRestaurants]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($user = $model->verifyEmail()) {
            if (Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
                return $this->goHome();
            }
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }

    /**
     * Restaurants page.
     *  
     * @return mixed
     */
    public function actionRestaurants()
    {   
        $searchTerm = Yii::$app->request->get('RestaurantSearch')['name'];
        $id = Yii::$app->request->get('id', 0);
        if($id > 0){
            $restaurant = Restaurant::find()->where(['restaurantId' => $id])->one();

            $sql_avg_price = "select CAST(avg(price) as decimal(4,2)) as `media` from dishes where menuId in (SELECT menuId FROM menus WHERE restaurantId = $id);";
            $query_avg_price = Yii::$app->db->createCommand($sql_avg_price)->queryAll();
            return $this->render('restaurant', ['restaurant' => $restaurant, "avg" => $query_avg_price[0]['media'] === null ? '0' : $query_avg_price[0]['media']]);
        }else{
            if($searchTerm != null){
                $query = Restaurant::find()->where(['like', 'name', $searchTerm]);

                
                $searchModel = new RestaurantSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

                $pagination = new Pagination(['totalCount' => $query->count(), 'pageSize' => 10]);
                $restaurants = $query->offset($pagination->offset)->limit($pagination->limit)->all();
                return $this->render('restaurants', [
                    'restaurants' => $restaurants, 
                    'pagination' => $pagination,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    ]);

            }else{
                $query = Restaurant::find();
                
                $searchModel = new RestaurantSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    
                $pagination = new Pagination(['totalCount' => $query->count(), 'pageSize' => 10]);
                $restaurants = $query->offset($pagination->offset)->limit($pagination->limit)->all();
                return $this->render('restaurants', [
                    'restaurants' => $restaurants, 
                    'pagination' => $pagination,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    ]);
            }
        }
    }

    /**
     * Profile page.
     *  
     * @return mixed
     */
    public function actionProfile()
    {   
        $user = User::findIdentity(Yii::$app->user->identity->id);
        $profile = Profiles::findIdentity(Yii::$app->user->identity->id);

        
        if ($profile->load(Yii::$app->request->post()) && $profile->save())
            return $this->render('profile', ['user' => $user, "profile" => $profile]);
        
        return $this->render('profile', ['user' => $user, "profile" => $profile]);
    }
}
