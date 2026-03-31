<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class AuthControllerTest extends TestCase
{
    protected function setUp(): void
    {
        $_GET = [];
        $_POST = [];
        $_SESSION = [];
        $_SERVER = [];
    }

    private function injectPrivateProperty(object $object, string $propertyName, mixed $value): void
    {
        $reflection = new ReflectionClass($object);
        $property = $reflection->getProperty($propertyName);
        $property->setAccessible(true);
        $property->setValue($object, $value);
    }

    public function testLoginGetAfficheLeFormulaire(): void
    {
        $twig = new TwigSpy('PAGE_LOGIN');
        $controller = new AuthController($twig);

        $_SERVER['REQUEST_METHOD'] = 'GET';

        ob_start();
        $controller->login();
        $output = ob_get_clean();

        $this->assertSame('PAGE_LOGIN', $output);
        $this->assertSame('auth/login.html.twig', $twig->lastTemplate);
        $this->assertArrayHasKey('erreur', $twig->lastContext);
        $this->assertSame('', $twig->lastContext['erreur']);
        $this->assertArrayHasKey('titre_page', $twig->lastContext);
    }

    public function testLoginPostInvalideAfficheUneErreur(): void
    {
        $twig = new TwigSpy('PAGE_LOGIN_ERREUR');
        $controller = new AuthController($twig);

        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['email'] = 'faux@email.fr';
        $_POST['password'] = 'mauvais-mot-de-passe';

        $fakeModel = new class {
            public function findByEmail($email)
            {
                return null;
            }
        };

        $this->injectPrivateProperty($controller, 'model', $fakeModel);

        ob_start();
        $controller->login();
        $output = ob_get_clean();

        $this->assertSame('PAGE_LOGIN_ERREUR', $output);
        $this->assertSame('auth/login.html.twig', $twig->lastTemplate);
        $this->assertSame('Email ou mot de passe incorrect.', $twig->lastContext['erreur']);
    }

    public function testLoginPostMotDePasseIncorrectAfficheUneErreur(): void
    {
        $twig = new TwigSpy('PAGE_LOGIN_ERREUR');
        $controller = new AuthController($twig);

        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['email'] = 'admin@stagepro.fr';
        $_POST['password'] = 'mauvais';

        $fakeUser = [
            'id' => 1,
            'nom' => 'Admin',
            'prenom' => 'StagePro',
            'email' => 'admin@stagepro.fr',
            'mot_de_passe' => password_hash('bon-mot-de-passe', PASSWORD_DEFAULT),
            'role_nom' => 'admin',
        ];

        $fakeModel = new class($fakeUser) {
            public function __construct(private array $fakeUser)
            {
            }

            public function findByEmail($email)
            {
                return $this->fakeUser;
            }
        };

        $this->injectPrivateProperty($controller, 'model', $fakeModel);

        ob_start();
        $controller->login();
        $output = ob_get_clean();

        $this->assertSame('PAGE_LOGIN_ERREUR', $output);
        $this->assertSame('auth/login.html.twig', $twig->lastTemplate);
        $this->assertSame('Email ou mot de passe incorrect.', $twig->lastContext['erreur']);
    }
}
