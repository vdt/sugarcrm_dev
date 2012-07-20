<?php
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2012 SugarCRM Inc.
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 * 
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/


class Bug52544Test extends Sugar_PHPUnit_Framework_TestCase
{
    /**
     * @var User
     */
    protected $user1;

    public function setUp()
    {
        $this->user1 = SugarTestUserUtilities::createAnonymousUser();
        $user2 = SugarTestUserUtilities::createAnonymousUser();
        $user2->reports_to_id = $this->user1->id;
        $user2->save();
        $user3 = SugarTestUserUtilities::createAnonymousUser();
        $user3->reports_to_id = $this->user1->id;
        $user3->save();
    }

    public function tearDown()
    {
        SugarTestUserUtilities::removeAllCreatedAnonymousUsers();
    }

    public function testGetSubpanelQueryReturnsArray()
    {
        // Load up the relationship
        if ( ! $this->user1->load_relationship('reportees') ) {
            // The relationship did not load, I'm guessing it doesn't exist
            $this->fail('Could not find a relationship named: reportees');
        }
        $linkQueryParts = $this->user1->reportees->getSubpanelQuery(array('return_as_array'=>true));

        $this->assertTrue(is_array($linkQueryParts));
    }

}