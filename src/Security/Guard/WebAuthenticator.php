<?php

/**
 * WebAuthenticator
 * authentification interface web
 * php version 7.2.5
 *
 * @category   Security
 * @package    Producteurauconsommateur
 * @subpackage App\Security\Guard
 * @author     Bernard Thomas <ynofmys@gmail.com>
 * @copyright  2020 Bernard Thomas
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @version    GIT: feature/registration
 * @link       http://producteurauconsommateur.com/
 */

declare(strict_types=1);

namespace App\Security\Guard;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Guard\AuthenticatorInterface;
use Symfony\Component\Security\Guard\PasswordAuthenticatedInterface;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;

/**
 * Class WebAuthenticator
 * authentification interface web
 *
 * @category Security
 * @package  App\Security\Guard
 * @author   Bernard Thomas <ynofmys@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://producteurauconsommateur.com/
 */
class WebAuthenticator extends AbstractGuardAuthenticator implements
    PasswordAuthenticatedInterface,
    AuthenticationEntryPointInterface,
    AuthenticatorInterface
{
    /**
     * Route de login
     *
     * @var string  route de login
     */
    public const LOGIN_ROUTE = 'security_login';
    /**
     * Gestionnaire d'entité
     *
     * @var EntityManagerInterface Gestionnaire d'entité
     */
    private $entityManager;

    /**
     * Générateur d'url
     *
     * @var UrlGeneratorInterface Générateur d'url
     */
    private $urlGenerator;

    /**
     * Gestionnaire de token CSRF
     *
     * @var CsrfTokenManagerInterface Gestionnaire de token CSRF
     */
    private $csrfTokenManager;

    /**
     * Utilitaire mot de passe
     *
     * @var UserPasswordEncoderInterface Utilitaire mot de passe
     */
    private $passwordEncoder;

    /**
     * WebAuthenticator constructor.
     *
     * @param EntityManagerInterface $entityManager         Gestionnaire d'entité
     * @param UrlGeneratorInterface $urlGenerator           Générateur d'url
     * @param CsrfTokenManagerInterface $csrfTokenManager   Gestionnaire de token CSRF
     * @param UserPasswordEncoderInterface $passwordEncoder Utilitaire mot de passe
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        UrlGeneratorInterface $urlGenerator,
        CsrfTokenManagerInterface $csrfTokenManager,
        UserPasswordEncoderInterface $passwordEncoder
    ) {
        $this->entityManager = $entityManager;
        $this->urlGenerator = $urlGenerator;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * Méthode jouée à chaque request
     * Si elle renvoit false l'authentification est necessaire
     *
     * @param Request $request objet Request
     *
     * @return bool
     */
    public function supports(Request $request): bool
    {
        return self::LOGIN_ROUTE === $request->attributes->get('_route')
            && $request->isMethod('POST');
    }

    /**
     * Méthode jouée à chaque request
     * Retourne toutes les informations de connection necessaires dans la variable $credential
     * utilisée ensuite dans la méthode getUser
     *
     * @param Request $request objet Request
     *
     * @return array
     */
    public function getCredentials(Request $request): array
    {
        $credentials = [
            'email' => $request->request->get('email'),
            'password' => $request->request->get('password'),
            'csrf_token' => $request->request->get('_csrf_token'),
        ];
        $request->getSession()->set(
            Security::LAST_USERNAME,
            $credentials['email']
        );

        return $credentials;
    }

    /**
     * Vérifie le token CSRF, cherche l'utilisateur en base de donnée
     * et retourne l'utilisateur
     *
     * @param array                 $credentials  informations de connection
     * @param UserProviderInterface $userProvider ne sert à rien ?
     *
     * @return UserInterface
     */
    public function getUser($credentials, UserProviderInterface $userProvider): UserInterface
    {
        $token = new CsrfToken('authenticate', $credentials['csrf_token']);
        if (!$this->csrfTokenManager->isTokenValid($token)) {
            throw new InvalidCsrfTokenException();
        }
        $user = $this->entityManager->getRepository(User::class)->findOneBy([
            'email' => $credentials['email']
        ]);
        if (!$user) {
            throw new CustomUserMessageAuthenticationException('Cette adresse email n\'existe pas.');
        }

        return $user;
    }

    /**
     * Vérifie le mot de passe
     *
     * @param array         $credentials informations de connection
     * @param UserInterface $user        Utilisateur avec mot de passe etc
     *
     * @return bool
     */
    public function checkCredentials($credentials, UserInterface $user): bool
    {
        return $this->passwordEncoder->isPasswordValid($user, $credentials['password']);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     *
     * @param mixed $credentials informations de connection
     *
     * @return string|null       mot de passe
     */
    public function getPassword($credentials): ?string
    {
        return $credentials['password'];
    }

    /**
     * Redirection après succes d'authentification
     *
     * @param Request        $request     objet Request
     * @param TokenInterface $token       jeton de sécurité
     * @param string         $providerKey va savoir ?
     *
     * @return RedirectResponse
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey): RedirectResponse
    {
        return new RedirectResponse($this->urlGenerator->generate("index"));
    }

    /**
     * Route du login
     *
     * @return string
     */
    protected function getLoginUrl(): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }

    /**
     * Route du login
     *
     * @param Request $request                            objet Request
     * @param AuthenticationException|null $authException Exception
     *
     * @return string
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }

    /**
     * Called when authentication executed, but failed (e.g. wrong username password).
     *
     * This should return the Response sent back to the user, like a
     * RedirectResponse to the login page or a 401 response.
     *
     * If you return null, the request will continue, but the user will
     * not be authenticated. This is probably not what you want to do.
     *
     * @param Request $request                   objet Request
     * @param AuthenticationException $exception Exception
     *
     * @return RedirectResponse
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new RedirectResponse($this->urlGenerator->generate("security_logout"));
    }

    /**
     * Does this method support remember me cookies?
     *
     * Remember me cookie will be set if *all* of the following are met:
     *  A) This method returns true
     *  B) The remember_me key under your firewall is configured
     *  C) The "remember me" functionality is activated. This is usually
     *      done by having a _remember_me checkbox in your form, but
     *      can be configured by the "always_remember_me" and "remember_me_parameter"
     *      parameters under the "remember_me" firewall key
     *  D) The onAuthenticationSuccess method returns a Response object
     *
     * @return bool
     */
    public function supportsRememberMe()
    {
        return false;
    }
}
