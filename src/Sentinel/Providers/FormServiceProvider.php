<?php namespace Sentinel\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Session\Store;
use Sentinel\Service\Form\Login\LoginForm;
use Sentinel\Service\Form\Login\LoginFormLaravelValidator;
use Sentinel\Service\Form\Register\RegisterForm;
use Sentinel\Service\Form\Register\RegisterFormLaravelValidator;
use Sentinel\Service\Form\Group\GroupForm;
use Sentinel\Service\Form\Group\GroupFormLaravelValidator;
use Sentinel\Service\Form\User\UserForm;
use Sentinel\Service\Form\User\UserFormLaravelValidator;
use Sentinel\Service\Form\ResendActivation\ResendActivationForm;
use Sentinel\Service\Form\ResendActivation\ResendActivationFormLaravelValidator;
use Sentinel\Service\Form\ForgotPassword\ForgotPasswordForm;
use Sentinel\Service\Form\ForgotPassword\ForgotPasswordFormLaravelValidator;
use Sentinel\Service\Form\ChangePassword\ChangePasswordForm;
use Sentinel\Service\Form\ChangePassword\ChangePasswordFormLaravelValidator;
use Sentinel\Service\Form\SuspendUser\SuspendUserForm;
use Sentinel\Service\Form\SuspendUser\SuspendUserFormLaravelValidator;

class FormServiceProvider extends ServiceProvider {

    /**
     * Register the binding
     *
     * @return void
     */
    public function register()
    {
        $app = $this->app;



    }

}