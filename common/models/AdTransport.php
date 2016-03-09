<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "ad_transport".
 *
 * @transport integer $id
 * @transport integer $transport
 * @transport integer $deal_type
 * @transport integer $id_car_model
 * @transport integer $mileage
 * @transport integer $measurement_of_mileage
 * @transport integer $price
 * @transport integer $price_for_the_period
 * @transport integer $equipment
 * @transport integer $exterior_color
 * @transport integer $interior_color
 * @transport integer $condition
 * @transport integer $images_label
 * @transport string $video_link
 * @transport string $model_scenario
 *
 * @transport AdTransportReference $condition0
 * @transport AdTransportReference $equipment0
 * @transport AdTransportReference $exteriorColor
 * @transport AdTransportReference $interiorColor
 * @transport CarModel $idCarModel
 * @transport AdTransportReference $dealType
 * @transport AdTransportReference $measurementOfMileage
 * @transport AdTransportReference $priceForThePeriod
 * @transport AdTransportReference $transport0
 * @transport AdTransport[] $transporttransportTypeList
 * @transport AdTransport[] $transportOperationTypeList
 * @transport AdTransport[] $passengerCarsMarksList
 * @transport AdTransport[] $passengerCarsModelsList
 * @transport AdTransport[] $passengerCarsGenerationList
 * @transport AdTransport[] $passengerCarsSerieList
 */
class AdTransport extends ActiveRecord
{
    public $place_city;
    public $place_city_id;
    public $place_city_validate;
    public $mark;
    public $model;
    public $generation;
    public $serie;
    public $trim;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ad_transport';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['transport', 'deal_type', 'id_car_model'], 'required'],
            [['transport', 'deal_type', 'id_car_model', 'mileage', 'measurement_of_mileage', 'price', 'price_for_the_period', 'equipment', 'exterior_color',
                'interior_color', 'condition', 'images_label', 'mark', 'model', 'generation', 'serie', 'trim'], 'integer'],
            [['video_link', 'model_scenario'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'transport' => Yii::t('app', 'Transport'),
            'deal_type' => Yii::t('app', 'Deal Type'),
            'id_car_model' => Yii::t('app', 'Id Car Model'),
            'mileage' => Yii::t('app', 'Mileage'),
            'measurement_of_mileage' => Yii::t('app', 'Measurement Of Mileage'),
            'price' => Yii::t('app', 'Price'),
            'price_for_the_period' => Yii::t('app', 'Price For The Period'),
            'equipment' => Yii::t('app', 'Equipment'),
            'exterior_color' => Yii::t('app', 'Exterior Color'),
            'interior_color' => Yii::t('app', 'Interior Color'),
            'condition' => Yii::t('app', 'Condition'),
            'images_label' => Yii::t('app', 'Images Label'),
            'video_link' => Yii::t('app', 'Video Link'),
            'model_scenario' => Yii::t('app', 'Model Scenario'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdCategory()
    {
        return $this->hasOne(AdCategory::className(),
            [
                'ad_id' => 'id',
                'category' => 'images_label',
            ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCondition0()
    {
        return $this->hasOne(AdTransportReference::className(), ['id' => 'condition']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEquipment0()
    {
        return $this->hasOne(AdTransportReference::className(), ['id' => 'equipment']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExteriorColor()
    {
        return $this->hasOne(AdTransportReference::className(), ['id' => 'exterior_color']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInteriorColor()
    {
        return $this->hasOne(AdTransportReference::className(), ['id' => 'interior_color']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCarModel()
    {
        return $this->hasOne(CarModel::className(), ['id_car_model' => 'id_car_model']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDealType()
    {
        return $this->hasOne(AdTransportReference::className(), ['id' => 'deal_type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMeasurementOfMileage()
    {
        return $this->hasOne(AdTransportReference::className(), ['id' => 'measurement_of_mileage']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPriceForThePeriod()
    {
        return $this->hasOne(AdTransportReference::className(), ['id' => 'price_for_the_period']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransport0()
    {
        return $this->hasOne(AdTransportReference::className(), ['id' => 'transport']);
    }

    /**
     * Returns the array of possible user status values.
     *
     * @return array
     */
    public function getTransportTypeList()
    {
        $realEstatetransport = ArrayHelper::map(AdTransportReference::find()
            ->where(['reference_id' => 16])
            ->all(), 'id', 'reference_name');

        $items = [];
        foreach($realEstatetransport as $key => $value):
            switch ($key) {
                case 1:
                    $items[] = [
                        'label' => Yii::t('transport', $value),
                        'url' => ['/ad/transport/create-passenger-car'],
                    ];
                    break;
            }
        endforeach;

        return $items;
    }

    /**
     * Returns the array of possible user status values.
     *
     * @return array
     */
    public function getTransportOperationTypeList()
    {
        switch ($this->transport) {
            case 1:
                $transport_operations = ArrayHelper::map(AdTransportReference::find()
                    ->where(['reference_id' => $this->transport])
                    ->all(), 'id', 'reference_name');
                $items = [];
                foreach($transport_operations as $key => $value) {
                    $items[$key] = Yii::t('transport', $value);
                }
                return $items;
        }
        return false;
    }

    /**
     * Returns the array of possible user status values.
     *
     * @return array
     */
    public function getPassengerCarsMarksList()
    {
        $transport_operations = ArrayHelper::map(CarMake::find()
            ->all(), 'id_car_make', 'name');
        $items = [];
        foreach($transport_operations as $key => $value) {
            $items[$key] = Yii::t('transport', $value);
        }
        return $items;
    }

    /**
     * Returns the array of possible user status values.
     *
     * @return array
     */
    public function getPassengerCarsModelsList()
    {
        $transport_operations = ArrayHelper::map(CarModel::find()
            ->where(['id_car_make' => $this->mark])
            ->all(), 'id_car_model', 'name');
        $items = [];
        foreach($transport_operations as $key => $value) {
            $items[$key] = Yii::t('transport', $value);
        }
        return $items;
    }

    /**
     * Returns the array of possible user status values.
     *
     * @return array
     */
    public function getPassengerCarsGenerationList()
    {
        $transport_operations = ArrayHelper::map(CarGeneration::find()
            ->where(['id_car_model' => $this->model])
            ->all(), 'id_car_generation', 'name');
        $items = [];
        foreach($transport_operations as $key => $value) {
            $items[$key] = Yii::t('transport', $value);
        }
        return $items;
    }

    /**
     * Returns the array of possible user status values.
     *
     * @return array
     */
    public function getPassengerCarsSerieList()
    {
        $transport_operations = ArrayHelper::map(CarSerie::find()
            ->where(['id_car_model' => $this->model])
            ->all(), 'id_car_serie', 'name');
        $items = [];
        foreach($transport_operations as $key => $value) {
            $items[$key] = Yii::t('transport', $value);
        }
        return $items;
    }

    /**
     * Returns the array of possible user status values.
     *
     * @return array
     */
    public function getPassengerCarsTrimList()
    {
        $transport_operations = ArrayHelper::map(CarTrim::find()
            ->where(['id_car_model' => $this->model])
            ->all(), 'id_car_trim', 'name');
        $items = [];
        foreach($transport_operations as $key => $value) {
            $items[$key] = Yii::t('transport', $value);
        }
        return $items;
    }

    /**
     * Returns the array of possible user status values.
     *
     * @return array
     *
     */
    public function addNewScenario($dealType, $transport, $scenario)
    {
        $modelAdTransport = new AdTransport(['scenario' => $scenario]);
        $modelAdTransport->transport = $transport;
        $modelAdTransport->deal_type = $dealType;
        $modelAdTransport->place_city = \Yii::$app->getRequest()->getCookies()->getValue('_city');
        return $modelAdTransport;
    }
}
