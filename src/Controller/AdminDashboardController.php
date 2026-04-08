<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class AdminDashboardController extends AbstractController
{
    public function dashboard(Request $request): Response
    {
        return $this->renderDashboard('Dashboard Utilisateurs', $request);
    }

    public function offreDashboard(Request $request): Response
    {
        return $this->renderDashboard('Dashboard Offres', $request);
    }

    public function candidatures(Request $request): Response
    {
        return $this->renderDashboard('Dashboard Candidatures', $request);
    }

    public function entretiens(Request $request): Response
    {
        return $this->renderDashboard('Dashboard Entretiens', $request);
    }

    public function recrutements(Request $request): Response
    {
        return $this->renderDashboard('Dashboard Recrutements', $request);
    }

    public function forum(Request $request): Response
    {
        return $this->renderDashboard('Forum', $request);
    }

    public function reports(Request $request): Response
    {
        return $this->renderDashboard('Rapports', $request);
    }

    public function statistiques(Request $request): Response
    {
        return $this->renderDashboard('Statistiques utilisateurs', $request);
    }

    public function logout(): RedirectResponse
    {
        return $this->redirectToRoute('app_admin_dashboard');
    }

    private function renderDashboard(string $title, Request $request): Response
    {
        return $this->render('admin/dashboard.html.twig', [
            'pageTitle' => $title,
            'adminName' => 'Khadhraoui Azer',
            'stats' => [
                'total' => 10,
                'admins' => 2,
                'clients' => 8,
            ],
            'users' => $this->getSampleUsers(),
            'search' => $request->query->get('search', ''),
            'roleFilter' => $request->query->get('role', ''),
            'sortBy' => $request->query->get('sortBy', 'id'),
            'sortOrder' => $request->query->get('sortOrder', 'DESC'),
        ]);
    }

    private function getSampleUsers(): array
    {
        return [
            ['id' => 101, 'imageProfil' => null, 'nom' => 'Ben Salah', 'prenom' => 'Maha', 'email' => 'maha.bensalah@example.com', 'role' => 'ADMIN_RH'],
            ['id' => 102, 'imageProfil' => null, 'nom' => 'Trabelsi', 'prenom' => 'Nizar', 'email' => 'nizar.trabelsi@example.com', 'role' => 'CLIENT'],
            ['id' => 103, 'imageProfil' => null, 'nom' => 'Saidi', 'prenom' => 'Amina', 'email' => 'amina.saidi@example.com', 'role' => 'ADMIN_TECHNIQUE'],
        ];
    }
}
