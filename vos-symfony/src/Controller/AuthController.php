<?php

namespace App\Controller;

use App\Dto\SignupDto;
use App\Entity\User;
use App\Form\SignupType;
use App\Repository\UserRepository;
use App\Service\PasswordResetService;
use App\Service\UserAccountService;
use App\Service\ValidationService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
    #[Route('/', name: 'app_home', methods: ['GET'])]
    public function home(): Response
    {
        return $this->redirectToRoute('app_client_accueil');
    }

    #[Route('/signup', name: 'app_signup')]
    public function signup(
        Request $request,
        UserAccountService $userAccountService,
        SessionInterface $session
    ): Response {
        $redirect = $this->redirectAuthenticatedUser($session);
        if ($redirect instanceof RedirectResponse) {
            return $redirect;
        }

        $signupDto = new SignupDto();
        $form = $this->createForm(SignupType::class, $signupDto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $userAccountService->register($signupDto, $form->get('imageFile')->getData());

                $this->addFlash('success', sprintf(
                    'Bienvenue %s %s, votre compte a ete cree avec succes !',
                    $signupDto->prenom,
                    $signupDto->nom
                ));

                return $this->redirectToRoute('app_signup');
            } catch (\Throwable $exception) {
                $this->addFlash('error', $exception->getMessage());
                return $this->redirectToRoute('app_signup');
            }
        }

        return $this->render('auth/signup.html.twig', [
            'signupForm' => $form->createView(),
        ]);
    }

    #[Route('/signin', name: 'app_signin')]
    public function signin(
        Request $request,
        UserAccountService $userAccountService,
        UserRepository $userRepository,
        SessionInterface $session
    ): Response
    {
        $redirect = $this->redirectAuthenticatedUser($session);
        if ($redirect instanceof RedirectResponse) {
            return $redirect;
        }

        if ($request->isMethod('POST')) {
            try {
                $token = (string) $request->request->get('_token');
                if (!$this->isCsrfTokenValid('signin_form', $token)) {
                    $this->addFlash('error', 'Token invalide. Veuillez reessayer.');
                    return $this->redirectToRoute('app_signin');
                }

                $email = trim((string) $request->request->get('email', ''));
                $password = (string) $request->request->get('password', '');
                $faceAuthMode = (string) $request->request->get('face_auth_mode', '0');
                $faceSimilarity = (float) $request->request->get('face_similarity', 0);

                if ($email === '') {
                    $this->addFlash('error', 'Email obligatoire.');
                    return $this->redirectToRoute('app_signin');
                }

                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $this->addFlash('error', 'Format email invalide.');
                    return $this->redirectToRoute('app_signin');
                }

                if ($faceAuthMode === '1') {
                    if ($faceSimilarity < 70.0) {
                        $this->addFlash('error', sprintf('NN: similitude insuffisante (%.1f%%).', $faceSimilarity));
                        return $this->redirectToRoute('app_signin');
                    }

                    $user = $userRepository->findByEmail($email);
                    if (!$user || !$user->getImageProfil()) {
                        $this->addFlash('error', 'Compte introuvable ou image de reference absente.');
                        return $this->redirectToRoute('app_signin');
                    }

                    $this->createSessionForUser($session, $user);

                    if (str_starts_with($user->getRole(), 'ADMIN')) {
                        return $this->redirectToRoute('app_admin_dashboard');
                    }

                    return $this->redirectToRoute('client_opportunites');
                }

                if ($password === '') {
                    $this->addFlash('error', 'Mot de passe obligatoire ou utilisez la reconnaissance faciale.');
                    return $this->redirectToRoute('app_signin');
                }

                $user = $userAccountService->authenticateAdmin($email, $password);

                if (!$user) {
                    // Essayer une connexion client
                    $user = $userAccountService->authenticateUser($email, $password);

                    if (!$user) {
                        $this->addFlash('error', 'Email ou mot de passe invalide.');
                        return $this->redirectToRoute('app_signin');
                    }

                    $this->createSessionForUser($session, $user);

                    return $this->redirectToRoute('client_opportunites');
                }

                $this->createSessionForUser($session, $user);

                return $this->redirectToRoute('app_admin_dashboard');
            } catch (\Throwable) {
                $this->addFlash('error', 'Email ou mot de passe invalide.');
                return $this->redirectToRoute('app_signin');
            }
        }

        return $this->render('auth/signin.html.twig', []);
    }

    #[Route('/signin/face-reference', name: 'app_signin_face_reference', methods: ['GET'])]
    public function signinFaceReference(Request $request, UserRepository $userRepository): JsonResponse
    {
        $email = trim((string) $request->query->get('email', ''));
        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return new JsonResponse(['ok' => false, 'message' => 'Email invalide.'], Response::HTTP_BAD_REQUEST);
        }

        $user = $userRepository->findByEmail($email);
        if (!$user) {
            return new JsonResponse(['ok' => false, 'message' => 'Compte introuvable.'], Response::HTTP_NOT_FOUND);
        }

        $faceDescriptor = null;
        if ($user->getFaceDescriptor()) {
            $decoded = json_decode((string) $user->getFaceDescriptor(), true);
            if (is_array($decoded)) {
                $faceDescriptor = array_map(static fn ($value) => (float) $value, $decoded);
            }
        }

        if (!$user->getImageProfil() && !$faceDescriptor) {
            return new JsonResponse(['ok' => false, 'message' => 'Aucune reference faciale disponible.'], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse([
            'ok' => true,
            'imageUrl' => $user->getImageProfil(),
            'referenceDescriptor' => $faceDescriptor,
        ]);
    }

    #[Route('/logout', name: 'app_logout', methods: ['POST'])]
    public function logout(SessionInterface $session): Response
    {
        if (!$session->isStarted()) {
            $session->start();
        }

        $session->remove('admin_user_id');
        $session->remove('admin_user_role');
        $session->remove('admin_user_name');
        $session->remove('user_id');
        $session->remove('user_role');
        $session->remove('user_name');
        $session->remove('auth_scope');
        $session->invalidate();

        $this->addFlash('success', 'Déconnexion réussie.');

        $response = $this->redirectToRoute('app_signin');
        $response->headers->clearCookie(session_name());
        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0, private');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', '0');

        return $response;
    }

    #[Route('/contact', name: 'app_contact', methods: ['GET'])]
    public function contact(): Response
    {
        return $this->render('static/contact.html.twig');
    }

    #[Route('/about', name: 'app_about', methods: ['GET'])]
    public function about(): Response
    {
        return $this->render('static/about.html.twig');
    }

    #[Route('/forgot-password', name: 'app_forgot_password', methods: ['GET', 'POST'])]
    public function forgotPassword(Request $request, PasswordResetService $passwordResetService, ValidationService $validation): Response
    {
        $emailValue = '';

        if ($request->isMethod('POST')) {
            $token = (string) $request->request->get('_token', '');
            if (!$this->isCsrfTokenValid('forgot_password_request', $token)) {
                $this->addFlash('error', 'Session invalide, veuillez reessayer.');
                return $this->redirectToRoute('app_forgot_password');
            }

            $emailValue = trim((string) $request->request->get('email', ''));

            try {
                $email = $validation->validateEmail($emailValue);
                $passwordResetService->requestReset($email, $request->getClientIp());

                // Message volontairement generique pour eviter l'enumeration d'emails.
                $this->addFlash('success', 'Si un compte existe avec cet email, un code de reinitialisation a ete envoye.');
                return $this->redirectToRoute('app_reset_password', ['email' => $email]);
            } catch (\Throwable $exception) {
                $this->addFlash('error', $exception->getMessage());
            }
        }

        return $this->render('auth/forgot_password.html.twig', [
            'emailValue' => $emailValue,
        ]);
    }

    #[Route('/reset-password', name: 'app_reset_password', methods: ['GET', 'POST'])]
    public function resetPassword(Request $request, PasswordResetService $passwordResetService, ValidationService $validation): Response
    {
        $emailValue = trim((string) $request->query->get('email', ''));

        if ($request->isMethod('POST')) {
            $csrfToken = (string) $request->request->get('_token', '');
            if (!$this->isCsrfTokenValid('reset_password_form', $csrfToken)) {
                $this->addFlash('error', 'Session invalide, veuillez reessayer.');
                return $this->redirectToRoute('app_reset_password');
            }

            $emailValue = trim((string) $request->request->get('email', ''));
            $code = preg_replace('/\D+/', '', (string) $request->request->get('code', ''));

            $password = (string) $request->request->get('password', '');
            $confirmPassword = (string) $request->request->get('confirmPassword', '');

            if ($password !== $confirmPassword) {
                $this->addFlash('error', 'Les mots de passe ne correspondent pas.');
                return $this->redirectToRoute('app_reset_password', ['email' => $emailValue]);
            }

            try {
                $email = $validation->validateEmail($emailValue);
                if (strlen((string) $code) !== 6) {
                    throw new \RuntimeException('Le code de reinitialisation doit contenir 6 chiffres.');
                }

                $validPassword = $validation->validatePassword($password, 8, 'mot de passe');
                $changed = $passwordResetService->resetPasswordWithCode($email, (string) $code, $validPassword);

                if (!$changed) {
                    $this->addFlash('error', 'Code invalide ou expire. Veuillez refaire une demande.');
                    return $this->redirectToRoute('app_forgot_password');
                }

                $this->addFlash('success', 'Mot de passe reinitialise avec succes. Vous pouvez maintenant vous connecter.');
                return $this->redirectToRoute('app_signin');
            } catch (\Throwable $exception) {
                $this->addFlash('error', $exception->getMessage());
                return $this->redirectToRoute('app_reset_password', ['email' => $emailValue]);
            }
        }

        return $this->render('auth/reset_password.html.twig', [
            'emailValue' => $emailValue,
        ]);
    }

    private function redirectAuthenticatedUser(SessionInterface $session): ?RedirectResponse
    {
        $adminUserId = (int) $session->get('admin_user_id', 0);
        $adminRole = (string) $session->get('admin_user_role', '');
        if ($adminUserId > 0 && str_starts_with($adminRole, 'ADMIN')) {
            return $this->redirectToRoute('app_admin_dashboard');
        }

        $userId = (int) $session->get('user_id', 0);
        $userRole = (string) $session->get('user_role', '');
        if ($userId > 0 && $userRole === 'CLIENT') {
            return $this->redirectToRoute('client_opportunites');
        }

        return null;
    }

    private function createSessionForUser(SessionInterface $session, User $user): void
    {
        if (!$session->isStarted()) {
            $session->start();
        }

        if (str_starts_with($user->getRole(), 'ADMIN')) {
            $session->remove('user_id');
            $session->remove('user_role');
            $session->remove('user_name');

            $session->set('admin_user_id', $user->getId());
            $session->set('admin_user_role', $user->getRole());
            $session->set('admin_user_name', trim(($user->getPrenom() ?? '') . ' ' . ($user->getNom() ?? '')));
            $session->set('auth_scope', 'admin');
            $session->save();

            return;
        }

        $session->remove('admin_user_id');
        $session->remove('admin_user_role');
        $session->remove('admin_user_name');

        $session->set('user_id', $user->getId());
        $session->set('user_role', $user->getRole());
        $session->set('user_name', trim(($user->getPrenom() ?? '') . ' ' . ($user->getNom() ?? '')));
        $session->set('auth_scope', 'client');
        $session->save();
    }
}
