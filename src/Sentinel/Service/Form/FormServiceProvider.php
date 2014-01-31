<?php namespace Sentinel\Service\Form;

use Illuminate\Support\ServiceProvider;
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

        // Bind the Login Form
        $app->bind('Sentinel\Service\Form\Login\LoginForm', function($app)
        {
            return new LoginForm(
                new LoginFormLaravelValidator( $app['validator'] ),
                $app->make('Sentinel\Repo\Session\SessionInterface')
            );
        });

        // Bind the Register Form
        $app->bind('Sentinel\Service\Form\Register\RegisterForm', function($app)
        {
            return new RegisterForm(
                new RegisterFormLaravelValidator( $app['validator'] ),
                $app->make('Sentinel\Repo\User\UserInterface')
            );
        });

        // Bind the Group Form
        $app->bind('Sentinel\Service\Form\Group\GroupForm', function($app)
        {
            return new GroupForm(
                new GroupFormLaravelValidator( $app['validator'] ),
                $app->make('Sentinel\Repo\Group\GroupInterface')
            );
        });

        // Bind the User Form
        $app->bind('Sentinel\Service\Form\User\UserForm', function($app)
        {
            return new UserForm(
                new UserFormLaravelValidator( $app['validator'] ),
                $app->make('Sentinel\Repo\User\UserInterface')
            );
        });

        // Bind the Resend Activation Form
        $app->bind('Sentinel\Service\Form\ResendActivation\ResendActivationForm', function($app)
        {
            return new ResendActivationForm(
                new ResendActivationFormLaravelValidator( $app['validator'] ),
                $app->make('Sentinel\Repo\User\UserInterface')
            );
        });

        // Bind the Forgot Password Form
        $app->bind('Sentinel\Service\Form\ForgotPassword\ForgotPasswordForm', function($app)
        {
            return new ForgotPasswordForm(
                new ForgotPasswordFormLaravelValidator( $app['validator'] ),
                $app->make('Sentinel\Repo\User\UserInterface')
            );
        });

        // Bind the Change Password Form
        $app->bind('Sentinel\Service\Form\ChangePassword\ChangePasswordForm', function($app)
        {
            return new ChangePasswordForm(
                new ChangePasswordFormLaravelValidator( $app['validator'] ),
                $app->make('Sentinel\Repo\User\UserInterface')
            );
        });

        // Bind the Suspend User Form
        $app->bind('Sentinel\Service\Form\SuspendUser\SuspendUserForm', function($app)
        {
            return new SuspendUserForm(
                new SuspendUserFormLaravelValidator( $app['validator'] ),
                $app->make('Sentinel\Repo\User\UserInterface')
            );
        });

    }

}