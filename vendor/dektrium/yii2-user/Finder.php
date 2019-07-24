<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace dektrium\user;

use dektrium\user\models\query\AccountQuery;
use dektrium\user\models\Token;
use yii\authclient\ClientInterface;
use yii\base\BaseObject;
use yii\db\ActiveQuery;

/**
 * Finder provides some useful methods for finding active record models.
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class Finder extends BaseObject
{
    /** @var ActiveQuery */
    protected $userQuery;

    /** @var ActiveQuery */
    protected $tokenQuery;

    /** @var AccountQuery */
    protected $accountQuery;

    /** @var ActiveQuery */
    protected $profileQuery;    
    protected $schoolQuery;
    protected $teacherQuery;

    /**
     * @return ActiveQuery
     */
    public function getUserQuery()
    {
        return $this->userQuery;
    }

    /**
     * @return ActiveQuery
     */
    public function getTokenQuery()
    {
        return $this->tokenQuery;
    }

    /**
     * @return ActiveQuery
     */
    public function getAccountQuery()
    {
        return $this->accountQuery;
    }

    /**
     * @return ActiveQuery
     */
    public function getProfileQuery()
    {
        return $this->profileQuery;
    }

    public function getSchoolQuery()
    {
        return $this->schoolQuery;
    }

    public function getTeacherQuery()
    {
        return $this->teacherQuery;
    }

    /** @param ActiveQuery $accountQuery */
    public function setAccountQuery(ActiveQuery $accountQuery)
    {
        $this->accountQuery = $accountQuery;
    }

    /** @param ActiveQuery $userQuery */
    public function setUserQuery(ActiveQuery $userQuery)
    {
        $this->userQuery = $userQuery;
    }

    /** @param ActiveQuery $tokenQuery */
    public function setTokenQuery(ActiveQuery $tokenQuery)
    {
        $this->tokenQuery = $tokenQuery;
    }

    public function setProfileQuery(ActiveQuery $profileQuery)
    {
        $this->profileQuery = $profileQuery;
    }

    public function setSchoolQuery(ActiveQuery $schoolQuery)
    {
        $this->schoolQuery = $schoolQuery;
    }

    public function setTeacherQuery(ActiveQuery $teacherQuery)
    {
        $this->teacherQuery = $teacherQuery;
    }

    public function findUserById($id)
    {
        return $this->findUser(['id' => $id])->one();
    }

    public function findUserByUsername($username)
    {
        return $this->findUser(['username' => $username])->one();
    }

    public function findUserByEmail($email)
    {
        return $this->findUser(['email' => $email])->one();
    }

    public function findUserByUsernameOrEmail($usernameOrEmail)
    {
        if (filter_var($usernameOrEmail, FILTER_VALIDATE_EMAIL)) {
            return $this->findUserByEmail($usernameOrEmail);
        }

        return $this->findUserByUsername($usernameOrEmail);
    }

    public function findUser($condition)
    {
        return $this->userQuery->where($condition);
    }

    public function findAccount()
    {
        return $this->accountQuery;
    }

    public function findAccountById($id)
    {
        return $this->accountQuery->where(['id' => $id])->one();
    }

    public function findToken($condition)
    {
        return $this->tokenQuery->where($condition);
    }

    public function findTokenByParams($userId, $code, $type)
    {
        return $this->findToken([
            'user_id' => $userId,
            'code'    => $code,
            'type'    => $type,
        ])->one();
    }

    public function findProfileById($id)
    {
        return $this->findProfile(['user_id' => $id])->one();
    }

    public function findProfile($condition)
    {
        return $this->profileQuery->where($condition);
    }

    public function findSchoolById($id)
    {
        return $this->findSchool(['user_id' => $id])->one();
    }

    public function findSchool($condition)
    {
        return $this->schoolQuery->where($condition);
    }

    public function findTeacherById($id)
    {
        return $this->findTeacher(['user_id' => $id])->one();
    }

    public function findTeacher($condition)
    {
        return $this->teacherQuery->where($condition);
    }
}
