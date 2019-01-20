<?php
/*
 * Copyright 2014 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */

class Google_Service_AdExchangeBuyerII_ServingRestriction extends Google_Collection
{
  protected $collection_key = 'disapprovalReasons';
  protected $contextsType = 'Google_Service_AdExchangeBuyerII_ServingContext';
  protected $contextsDataType = 'array';
  protected $disapprovalType = 'Google_Service_AdExchangeBuyerII_Disapproval';
  protected $disapprovalDataType = '';
  protected $disapprovalReasonsType = 'Google_Service_AdExchangeBuyerII_Disapproval';
  protected $disapprovalReasonsDataType = 'array';
  public $status;

  /**
   * @param Google_Service_AdExchangeBuyerII_ServingContext
   */
  public function setContexts($contexts)
  {
    $this->contexts = $contexts;
  }
  /**
   * @return Google_Service_AdExchangeBuyerII_ServingContext
   */
  public function getContexts()
  {
    return $this->contexts;
  }
  /**
   * @param Google_Service_AdExchangeBuyerII_Disapproval
   */
  public function setDisapproval(Google_Service_AdExchangeBuyerII_Disapproval $disapproval)
  {
    $this->disapproval = $disapproval;
  }
  /**
   * @return Google_Service_AdExchangeBuyerII_Disapproval
   */
  public function getDisapproval()
  {
    return $this->disapproval;
  }
  /**
   * @param Google_Service_AdExchangeBuyerII_Disapproval
   */
  public function setDisapprovalReasons($disapprovalReasons)
  {
    $this->disapprovalReasons = $disapprovalReasons;
  }
  /**
   * @return Google_Service_AdExchangeBuyerII_Disapproval
   */
  public function getDisapprovalReasons()
  {
    return $this->disapprovalReasons;
  }
  public function setStatus($status)
  {
    $this->status = $status;
  }
  public function getStatus()
  {
    return $this->status;
  }
}
