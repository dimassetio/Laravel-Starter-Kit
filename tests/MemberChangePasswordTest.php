<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MemberChangePasswordTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function member_can_change_password()
    {
        $this->visit('auth/login');
        $this->type('member','username');
        $this->type('member','password');
        $this->press('Login');
        $this->seePageIs('home');
        $this->click('Ganti Password');

        $this->type('member1','old_password');
        $this->type('rahasia','password');
        $this->type('rahasia','password_confirmation');
        $this->press('Ganti Password');
        $this->see('Password lama tidak cocok');

        $this->type('member','old_password');
        $this->type('rahasia','password');
        $this->type('rahasia','password_confirmation');
        $this->press('Ganti Password');
        $this->see('Password berhasil diubah');

        // Logout and login using new Password
        $this->click('Keluar');
        $this->seePageIs('auth/login');
        $this->type('member','username');
        $this->type('rahasia','password');
        $this->press('Login');
        $this->seePageIs('home');
    }
}
