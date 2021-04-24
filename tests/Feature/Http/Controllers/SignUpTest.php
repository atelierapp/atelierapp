<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;

/**
 * @testdox Registration
 */
class SignUpTest extends TestCase {

    /**
     * @test
     * @title Successful registration
     * @description An account can be created with valid data.
     */
    public function an_account_can_be_created_with_valid_data()
    {
        $this->markTestIncomplete();
    }

    /**
     * @test
     * @title Successful registration with social account
     * @description An account can be created with valid data linking the social account.
     */
    public function an_account_can_be_created_with_valid_data_linking_the_social_account()
    {
        $this->markTestIncomplete();
    }

    /**
     * @test
     * @title Invalid registration
     * @description An account can't be create with invalid data.
     */
    public function an_account_cannot_be_create_with_invalid_data(): void
    {
        $this->markTestIncomplete();
    }
}
