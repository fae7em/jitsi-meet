<?php

namespace humhubContrib\modules\jitsiMeet\models;

use Yii;
use yii\base\Model;

class SettingsForm extends Model
{

    public $jitsiDomain;
    public $menuTitle;
    public $roomPrefix;
    public $jitsiAppID;
    public $jitsiAppSecret;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['jitsiDomain', 'string'],
            [['menuTitle', 'jitsiAppID', 'jitsiAppSecret', 'roomPrefix'], 'string'],
        ];
    }

    public function attributeHints()
    {
        return [
            'jitsiDomain' => Yii::t('JitsiMeetModule.base', 'Default is meet.jit.si without "https://" prefix.'),
            'jitsiAppID' => Yii::t('JitsiMeetModule.base', 'Application ID shared with the server used to generate JWT token for authentication. Leave empty to not generate JWT token.'),
            'jitsiAppSecret' => Yii::t('JitsiMeetModule.base', 'Application secret shared with the server used to sign JWT token for authentication. Needed if JWT token should be generated.'),
            'menuTitle' => Yii::t('JitsiMeetModule.base', 'Default: Jitsi Meet'),
            'roomPrefix' => Yii::t('JitsiMeetModule.base', 'Default: empty, useful for public Jitsi server'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function init()
    {

        $this->menuTitle = Yii::$app->getModule('jitsi-meet')->settings->get('menuTitle');
        if (empty($this->menuTitle)) {
            $this->menuTitle = 'Jitsi Meet';
        }

        $this->jitsiDomain = Yii::$app->getModule('jitsi-meet')->settings->get('jitsiDomain');
        if (empty($this->jitsiDomain)) {
            $this->jitsiDomain = 'meet.jit.si';
        }

        $this->jitsiAppID = Yii::$app->getModule('jitsi-meet')->settings->get('jitsiAppID');
        if (empty($this->jitsiAppID)) {
            $this->jitsiAppID = '';
        }
        $this->jitsiAppSecret = Yii::$app->getModule('jitsi-meet')->settings->get('jitsiAppSecret');
        if (empty($this->jitsiAppSecret)) {
            $this->jitsiAppSecret = '';
        }

        $this->roomPrefix = Yii::$app->getModule('jitsi-meet')->settings->get('roomPrefix');
        if (empty($this->roomPrefix)) {
            $this->roomPrefix = '';
        }
    }

    /**
     * @inheritdoc
     */
    public function save()
    {
        Yii::$app->getModule('jitsi-meet')->settings->set('menuTitle', $this->menuTitle);
        Yii::$app->getModule('jitsi-meet')->settings->set('jitsiDomain', $this->jitsiDomain);
        Yii::$app->getModule('jitsi-meet')->settings->set('jitsiAppID', $this->jitsiAppID);
        Yii::$app->getModule('jitsi-meet')->settings->set('jitsiAppSecret', $this->jitsiAppSecret);

        $this->roomPrefix = ucwords(preg_replace("/[^A-Za-z0-9]/", '', $this->roomPrefix));
        Yii::$app->getModule('jitsi-meet')->settings->set('roomPrefix', $this->roomPrefix);

        return true;
    }
}
