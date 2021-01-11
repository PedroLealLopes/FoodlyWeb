<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\SignupForm;

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
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'index'],
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
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {   
        $today = $this->sql_requests('today');
        $month = $this->sql_requests('month');
        $year = $this->sql_requests('year');
        $every_month = $this->sql_requests('every_month');
        

        return $this->render('index', 
        [
        'today_earnings' =>  $today === null ? '0' : $today, 
        'monthly_earnings' => $month  === null ? '0' : $month, 
        'yearly_earnings' => $year  === null ? '0' : $year, 
        'every_month' => $every_month  === null ? '0' : $every_month, 
        ]);
    }

    public static function sql_requests(String $request){
        $sql_yearly_earnings = "select sum(d.price) as `Yearly Earnings` from orders o inner join order_items oi on o.orderId = oi.orderId inner join dishes d on oi.dishId = d.dishId where year(o.date) = year(NOW());
        ";

        $sql_montlhy_earnings = "select sum(d.price) as `Monthly Earnings` from orders o inner join order_items oi on o.orderId = oi.orderId inner join dishes d on oi.dishId = d.dishId where month(o.date) = month(NOW());";

        $sql_today_earnings = "select sum(d.price) as `Earnings Today` from orders o inner join order_items oi on o.orderId = oi.orderId inner join dishes d on oi.dishId = d.dishId where YEAR(o.date) = YEAR(NOW()) and MONTH(o.date) = MONTH(NOW()) AND DAY(o.date) = DAY(NOW());";

        $sql_every_month = "SELECT monthname(m.MONTH) as `Month`, coalesce(p.e, 0) as `Earning`
        FROM (
        SELECT '2020-1-1 10:28:00' AS
        MONTH
        UNION SELECT '2020-2-1 10:28:00' AS
        MONTH
        UNION SELECT '2020-3-1 10:28:00' AS
        MONTH
        UNION SELECT '2020-4-1 10:28:00' AS
        MONTH
        UNION SELECT '2020-5-1 10:28:00' AS
        MONTH
        UNION SELECT '2020-6-1 10:28:00' AS
        MONTH
        UNION SELECT '2020-7-1 10:28:00' AS
        MONTH
        UNION SELECT '2020-8-1 10:28:00' AS
        MONTH
        UNION SELECT '2020-9-1 10:28:00' AS
        MONTH
        UNION SELECT '2020-10-1 10:28:00' AS
        MONTH
        UNION SELECT '2020-11-1 10:28:00' AS
        MONTH
        UNION SELECT '2020-12-1 10:28:00' AS
        MONTH
        ) AS m 
            left JOIN (select coalesce(sum(d.price), 0) as e, o.date as m from orders o inner join order_items oi on o.orderId = oi.orderId inner join dishes d on oi.dishId = d.dishId where year(o.date) = year(NOW()) group by MONTH(o.date)) p
                ON monthname(p.m) = monthname(m.month) ORDER BY Month(m.MONTH);
        ";

        $query_yearly_earnings = Yii::$app->db->createCommand($sql_yearly_earnings)->queryAll();
        $query_montlhy_earnings = Yii::$app->db->createCommand($sql_montlhy_earnings)->queryAll();
        $query_today_earnings = Yii::$app->db->createCommand($sql_today_earnings)->queryAll();
        $query_every_month_earnings = Yii::$app->db->createCommand($sql_every_month)->queryAll();

        switch($request){
            case "today":
                return $query_today_earnings[0]['Earnings Today'];
            case "month":
                return $query_montlhy_earnings[0]['Monthly Earnings'];
            case "year":
                return $query_yearly_earnings[0]['Yearly Earnings'];
            case "every_month":
                return $query_every_month_earnings;
        }

        return null;
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

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
     * Signs user up.
     *  
     * @return mixed
     */
    public function actionSignup()
    {   
        $this->layout = 'blank';

        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
