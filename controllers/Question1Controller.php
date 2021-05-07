<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * Question1Controller
 */
class Question1Controller extends Controller
{
    public $d, $G1, $G2, $tam1, $tam2, $v, $kv, $kv1, $x, $lamda, $beta, $beta1, $anpha1, $kq;

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all DmTinhtoan models.
     * @return mixed
     */
    public function actionIndex()
    {


        if (Yii::$app->request->post()) {
            $d = sqrt((4*$_POST['varA']) / pi());
            $G1 = $_POST['varE1'] / (2*(1 + $_POST['varv1']));
            $G2 = $_POST['varE2'] / (2*(1 + $_POST['varv2']));
            $tam1 = ($_POST['varl']) / $d;
            $tam2 = ($G1*$_POST['varl']) / ($G2*$d);

            $v =($_POST['varv1'] + $_POST['varv2'])/ 2;
            $k1 = 2.82 - 3.78 * $v +2.18 * Pow($v, 2);
            $k2 = 2.82 - 3.78 * $_POST['varv1'] + (2.18*Pow($_POST['varv1'], 2));

            $x  = ($_POST['varE'] * $_POST['varA'])/ ($G1*Pow($_POST['varl'], 2));
            $lamda = (2.12*Pow ($x, 3/4)) / (1+2.12*Pow ($x, 3/4));

            $beta1 =  0.17 * log(($k1 * $G1*$_POST['varl'])/ ($G2 * $d));
            $anpha1 = 0.17 * log(($k2 * $_POST['varl']) / ($d));

            $beta = ($beta1/$lamda) + (0.5 * ((1 - ($beta1/$anpha1)) / $x));
            $kq = ($beta*$_POST['varN'])/ ($G1*$_POST['varl']);


            $phpWord = new \PhpOffice\PhpWord\PhpWord();

            /* Note: any element you append to a document must reside inside of a Section. */
    
            // Adding an empty Section to the document...
            // $section = $phpWord->addSection();

            // $section->addText(
            //     'THUYẾT MINH TÍNH TOÁN',
            //     array('name' => 'Tahoma', 'size' => 13, 'color' => '1B2232', 'bold' => true)
            // );

            // $section->addText(
            //     "Việc tính toán được thực hiện theo TCVN 10304-2014 mục 7.4.2. có tính đến sự điều chỉnh của hệ số β ".
            //     "Số liệu ban đầu: N = ".$_POST['varN']."MH, A = ".$_POST['varA']."m2, l = ".$_POST['varl']."m, E = ".$_POST['varE']."MPa, ν1 =".$_POST['varv1'].", ν2 =".$_POST['varv2'].", E1 = ".$_POST['varE1']." MPa, E2 = ".$_POST['varE2']." MPa"
            //     ,
            //     array('name' => 'Tahoma', 'size' => 12,)
            // );


            // $section->addText(
            //     "Tính toán: "
            //     ,
            //     array('name' => 'Tahoma', 'size' => 12,)
            // );


            
            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('template.docx');
            $templateProcessor->setValues(
                [
                    'varN' => $_POST['varN'],
                    'varA' => $_POST['varA']
                ]
            );


            $date = date_create();

            $timestamp = date_timestamp_get($date);
            $filename = 'question1_'.$timestamp.'.docx';
            $templateProcessor->saveAs($filename);
            // $phpWord = \PhpOffice\PhpWord\IOFactory::load($filename); 

            // $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($templateProcessor, 'Word2007');
            // $objWriter->save($filename);
            return 1;

        }
        return $this->render('index');
    }



    /**
     * Creates a new DmTinhtoan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        return Yii::$app->request->post();

        // if ($model->load(Yii::$app->request->post()) && $model->save()) {
        //     return $this->redirect(['view', 'id' => $model->id]);
        // }

        // return $this->render('create', [
        //     'model' => $model,
        // ]);
    }

  
}
