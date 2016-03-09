<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "ad_transport".
 *
 * @property integer $id
 * @property integer $transport
 * @property integer $deal_type
 * @property integer $id_car_model
 * @property integer $id_car_generation
 * @property integer $id_car_serie
 * @property integer $id_car_trim
 * @property integer $mileage
 * @property integer $measurement_of_mileage
 * @property integer $price
 * @property integer $price_for_the_period
 * @property integer $equipment
 * @property integer $exterior_color
 * @property integer $interior_color
 * @property integer $condition
 * @property integer $images_label
 * @property string $video_link
 * @property string $model_scenario
 *
 * @property AdTransportReference $condition0
 * @property AdTransportReference $equipment0
 * @property AdTransportReference $exteriorColor
 * @property AdTransportReference $interiorColor
 * @property CarGeneration $idCarGeneration
 * @property CarModel $idCarModel
 * @property CarSerie $idCarSerie
 * @property CarTrim $idCarTrim
 * @property AdTransportReference $dealType
 * @property AdTransportReference $measurementOfMileage
 * @property AdTransportReference $priceForThePeriod
 * @property AdTransportReference $transport0
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
            [['transport', 'deal_type', 'id_car_model', 'id_car_generation', 'id_car_serie', 'id_car_trim', 'mileage', 'measurement_of_mileage', 'price',
                'price_for_the_period', 'equipment', 'exterior_color', 'interior_color', 'condition', 'images_label', 'mark'], 'integer'],
            [['video_link', 'model_scenario'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('transport', 'ID'),
            'transport' => Yii::t('transport', 'Transport'),
            'deal_type' => Yii::t('transport', 'Deal Type'),
            'id_car_model' => Yii::t('transport', 'Model'),
            'id_car_generation' => Yii::t('transport', 'Generation'),
            'id_car_serie' => Yii::t('transport', 'Serie'),
            'id_car_trim' => Yii::t('transport', 'Modification'),
            'mileage' => Yii::t('transport', 'Mileage'),
            'measurement_of_mileage' => Yii::t('transport', 'Measurement Of Mileage'),
            'price' => Yii::t('transport', 'Price'),
            'price_for_the_period' => Yii::t('transport', 'Price For The Period'),
            'equipment' => Yii::t('transport', 'Equipment'),
            'exterior_color' => Yii::t('transport', 'Exterior Color'),
            'interior_color' => Yii::t('transport', 'Interior Color'),
            'condition' => Yii::t('transport', 'Condition'),
            'images_label' => Yii::t('transport', 'Images Label'),
            'video_link' => Yii::t('transport', 'Video Link'),
            'model_scenario' => Yii::t('transport', 'Model Scenario'),
            'mark' => Yii::t('transport', 'Mark'),
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
    public function getIdCarGeneration()
    {
        return $this->hasOne(CarGeneration::className(), ['id_car_generation' => 'id_car_generation']);
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
    public function getIdCarSerie()
    {
        return $this->hasOne(CarSerie::className(), ['id_car_serie' => 'id_car_serie']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCarTrim()
    {
        return $this->hasOne(CarTrim::className(), ['id_car_trim' => 'id_car_trim']);
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
            ->where(['id_car_model' => $this->id_car_model])
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
            ->where(['id_car_model' => $this->id_car_model])
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
            ->where(['id_car_model' => $this->id_car_model])
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
