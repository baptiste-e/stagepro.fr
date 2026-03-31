<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class CandidatureControllerTest extends TestCase
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

    public function testIndexPourAdminAfficheToutesLesCandidatures(): void
    {
        $twig = new TwigSpy('PAGE_ADMIN_CANDIDATURES');
        $controller = new CandidatureController($twig);

        $_SESSION['user'] = [
            'id' => 1,
            'role' => 'admin',
        ];

        $fakeModel = new class {
            public function findAllFull()
            {
                return [
                    [
                        'id' => 10,
                        'offre_titre' => 'Data Analyst',
                        'entreprise_nom' => 'DataFlow',
                    ],
                    [
                        'id' => 11,
                        'offre_titre' => 'Développeur Web Fullstack',
                        'entreprise_nom' => 'TechCorp',
                    ],
                ];
            }

            public function findByEtudiant($userId)
            {
                return [];
            }
        };

        $this->injectPrivateProperty($controller, 'model', $fakeModel);

        ob_start();
        $controller->index();
        $output = ob_get_clean();

        $this->assertSame('PAGE_ADMIN_CANDIDATURES', $output);
        $this->assertSame('candidatures/liste.html.twig', $twig->lastTemplate);
        $this->assertArrayHasKey('candidatures', $twig->lastContext);
        $this->assertCount(2, $twig->lastContext['candidatures']);
        $this->assertSame('admin', $twig->lastContext['role']);
        $this->assertSame('Gestion des candidatures | StagePro', $twig->lastContext['titre_page']);
    }

    public function testIndexPourEtudiantAfficheSesCandidatures(): void
    {
        $twig = new TwigSpy('PAGE_ETUDIANT_CANDIDATURES');
        $controller = new CandidatureController($twig);

        $_SESSION['user'] = [
            'id' => 3,
            'role' => 'etudiant',
        ];

        $fakeModel = new class {
            public function findAllFull()
            {
                return [];
            }

            public function findByEtudiant($userId)
            {
                return [
                    [
                        'id' => 5,
                        'offre_titre' => 'UX/UI Designer Junior',
                        'entreprise_nom' => 'CreativeLab',
                    ],
                ];
            }
        };

        $this->injectPrivateProperty($controller, 'model', $fakeModel);

        ob_start();
        $controller->index();
        $output = ob_get_clean();

        $this->assertSame('PAGE_ETUDIANT_CANDIDATURES', $output);
        $this->assertSame('candidatures/liste.html.twig', $twig->lastTemplate);
        $this->assertCount(1, $twig->lastContext['candidatures']);
        $this->assertSame('etudiant', $twig->lastContext['role']);
        $this->assertSame('Mes Candidatures | StagePro', $twig->lastContext['titre_page']);
    }

    public function testShowAfficheLeDetailQuandEtudiantAutorise(): void
    {
        $twig = new TwigSpy('PAGE_DETAIL_CANDIDATURE');
        $controller = new CandidatureController($twig);

        $_SESSION['user'] = [
            'id' => 3,
            'role' => 'etudiant',
        ];

        $fakeModel = new class {
            public function findByIdFull($id)
            {
                return [
                    'id' => 5,
                    'utilisateur_id' => 3,
                    'offre_titre' => 'Data Analyst',
                    'entreprise_nom' => 'DataFlow',
                    'lettre_motivation' => 'Je suis motivé',
                ];
            }
        };

        $this->injectPrivateProperty($controller, 'model', $fakeModel);

        ob_start();
        $controller->show(5);
        $output = ob_get_clean();

        $this->assertSame('PAGE_DETAIL_CANDIDATURE', $output);
        $this->assertSame('candidatures/detail.html.twig', $twig->lastTemplate);
        $this->assertArrayHasKey('candidature', $twig->lastContext);
        $this->assertSame(5, $twig->lastContext['candidature']['id']);
        $this->assertSame('etudiant', $twig->lastContext['role']);
        $this->assertSame('Détail candidature | StagePro', $twig->lastContext['titre_page']);
    }
}