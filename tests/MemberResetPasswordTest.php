<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MemberResetPasswordTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function member_can_reset_password_by_their_email()
    {
        // Reset Request
        $this->visit('auth/forgot-password');
        $this->notSeeInDatabase('password_resets', [
            'email' => 'member@app.dev'
        ]);
        $this->see('Reset Password');
        $this->type('member@app.dev','email');
        $this->press('Kirim Link Reset Password');
        $this->seePageIs('auth/forgot-password');
        $this->see('Kami sudah mengirim email');
        $this->seeInDatabase('password_resets', [
            'email' => 'member@app.dev'
        ]);

        // Reset Action
        $resetData = DB::table('password_resets')->where('email','member@app.dev')->first();
        $token = $resetData->token;

        $this->visit('auth/reset/' . $token);
        $this->see('Reset Password');
        $this->see('Password Baru');

        // Enter an invalid email
        $this->type('admin@app.dev','email');
        $this->type('rahasia','password');
        $this->type('rahasia','password_confirmation');
        $this->press('Reset Password');
        $this->see('Token Reset Password tidak sah');

        // Enter a valid email
        $this->type('member@app.dev','email');
        $this->type('rahasia','password');
        $this->type('rahasia','password_confirmation');
        $this->press('Reset Password');

        $this->seePageIs('home');

        $this->notSeeInDatabase('password_resets', [
            'email' => 'member@app.dev'
        ]);

        // Logout and login using new Password
        $this->click('Keluar');
        $this->seePageIs('auth/login');
        $this->type('member','username');
        $this->type('rahasia','password');
        $this->press('Login');
        $this->seePageIs('home');
    }

}
