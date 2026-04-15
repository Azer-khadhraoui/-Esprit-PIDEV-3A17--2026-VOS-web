# Guide d'Utilisation - Export PDF des Candidatures

## Récapitulatif des modifications

### 1. **Installation de la dépendance**
- **Librairie** : DOMPDF v3.1.5
- **Fonction** : Génération et téléchargement de PDF

### 2. **Fichiers créés**

#### Service
- **`src/Service/PdfService.php`** - Service centralisé pour générer les PDFs

#### Templates Twig (PDF)
- **`templates/pdf/candidature_detail.html.twig`** - Template pour le détail d'une candidature
- **`templates/pdf/candidatures_list_client.html.twig`** - Template pour la liste client
- **`templates/pdf/candidatures_list_admin.html.twig`** - Template pour la liste admin

### 3. **Routes ajoutées**

#### Pour les clients (CandidatureController)
| Route | Nom | Méthode | Description |
|-------|-----|--------|-------------|
| `/client/candidature/export-pdf` | `app_client_candidature_export_pdf` | GET | Export PDF liste des candidatures |
| `/client/candidature/{id_candidature}/export-pdf` | `app_client_candidature_detail_pdf` | GET | Export PDF détail candidature |

#### Pour les admins (AdminController)
| Route | Nom | Méthode | Description |
|-------|-----|--------|-------------|
| `/admin/candidatures/export-pdf` | `app_admin_candidatures_export_pdf` | GET | Export PDF liste (avec filtres) |
| `/admin/candidatures/{id}/export-pdf` | `app_admin_candidature_detail_pdf` | GET | Export PDF détail candidature |

### 4. **Modifications des templates existants**

#### Template Client - Liste des candidatures
- **Fichier** : `templates/client/candidature/index.html.twig`
- **Ajout** : Bouton "📄 Exporter en PDF" dans la section des contrôles

#### Template Client - Détail candidature
- **Fichier** : `templates/client/candidature/detail.html.twig`
- **Ajout** : Bouton "📄 Exporter en PDF" dans les actions

#### Template Admin - Liste des candidatures
- **Fichier** : `templates/admin/candidature/index.html.twig`
- **Ajout** : Bouton "📄 Exporter en PDF" (respecte les filtres appliqués)

#### Template Admin - Édition candidature
- **Fichier** : `templates/admin/candidature/edit.html.twig`
- **Ajout** : Bouton "📄 Exporter en PDF" dans les actions

---

## Guide d'utilisation

### Pour les CLIENTS

#### 1. **Exporter la liste complète**
1. Allez à "Mes Candidatures"
2. Cliquez sur le bouton **"📄 Exporter en PDF"**
3. Le fichier `mes_candidatures_JJ-MM-YYYY.pdf` sera téléchargé

#### 2. **Exporter le détail d'une candidature**
1. Allez à "Mes Candidatures"
2. Cliquez sur "Détails" pour une candidature
3. Cliquez sur **"📄 Exporter en PDF"** en haut
4. Le fichier `candidature_X_JJ-MM-YYYY.pdf` sera téléchargé (X = ID)

### Pour les ADMINS

#### 1. **Exporter la liste avec filtres**
1. Allez à "Gestion Candidatures"
2. (Optionnel) Appliquez des filtres :
   - Recherche par nom, prénom ou offre
   - Filtrer par statut
   - Trier par colonne
3. Cliquez sur **"📄 Exporter en PDF"**
4. Le fichier `candidatures_admin_JJ-MM-YYYY.pdf` sera téléchargé avec les candidatures filtrées

#### 2. **Exporter le détail d'une candidature**
1. Allez à "Gestion Candidatures"
2. Cliquez sur une candidature pour l'éditer
3. Cliquez sur **"📄 Exporter en PDF"** dans les actions
4. Le fichier `candidature_X_JJ-MM-YYYY.pdf` sera téléchargé (X = ID)

---

## Caractéristiques du PDF

### Design du PDF
- ✅ Entête professionnel avec logo VOS
- ✅ Code couleur cohérent (bleu #4361ee)
- ✅ Sections bien organisées avec séparations visuelles
- ✅ Tableau claire pour la liste des candidatures
- ✅ Statuts avec couleurs de code (En attente, En examens, Accepté, Refusé)

### Informations incluses

**Liste des candidatures (Client)**
- ID de chaque candidature
- Titre de l'offre d'emploi
- Date de candidature
- Statut de la candidature
- Total des candidatures

**Liste des candidatures (Admin)**
- ID de chaque candidature
- Nom et prénom du candidat
- Titre de l'offre d'emploi
- Date de candidature
- Statut de la candidature
- Total des candidatures

**Détail d'une candidature**
- Informations de la candidature (ID, date, statut)
- Informations du candidat (nom, email, téléphone)
- Détails de l'offre d'emploi (titre, entreprise, localisation)
- État des fichiers joints (CV et lettre de motivation)
- Date et heure d'édition du document

---

## Notes techniques

### Sécurité
- ✅ Vérification des permissions (authentification requise)
- ✅ Clients peuvent seulement exporter leurs propres candidatures
- ✅ Admins peuvent exporter toutes les candidatures
- ✅ Prise en compte des filtres côté serveur

### Performance
- ✅ Requêtes optimisées (jointures sélectives)
- ✅ Pas de requête N+1 grâce au chargement batch
- ✅ Génération à la demande

### Format
- ✅ Format PDF standard ISO 8601
- ✅ Taille raisonnable (généralement 50-100 KB)
- ✅ Prise en compte automatique du fuseau horaire

---

## Dépannage

### Le PDF ne se télécharge pas
1. Vérifiez que vous êtes authentifié
2. Vérifiez que le dossier `var/` a les permissions d'écriture
3. Vérifiez les logs : `var/log/dev.log`

### Le style du PDF est différent
- DOMPDF a des limitations CSS comparé aux navigateurs web
- Les polices doivent être disponibles sur le serveur
- Les images doivent être accessibles via une URL valide

### Problèmes de caractères spéciaux
- Le codage UTF-8 est correctement configuré dans les templates
- Les caractères accentués français sont supportés

---

## Améliorations futures possibles

- [ ] Ajouter une signature numérique au PDF
- [ ] Inclure les fichiers joints (CV, lettre) directement dans le PDF
- [ ] Ajouter un watermark "CONFIDENTIEL"
- [ ] Générer un rapport statistique en PDF
- [ ] Implémenter la génération asynchrone pour les grands lots
