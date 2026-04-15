# Configuration des Notifications par Email - VOS

## ✅ Étapes effectuées

1. ✓ Configuration du système de mailer Symfony
2. ✓ Service EmailService créé avec 6 méthodes d'envoi d'emails :
   - `sendCandidatureCreatedEmail()` - Email au candidat
   - `sendCandidatureUpdatedEmail()` - Notification de mise à jour
   - `sendCandidatureDeletedEmail()` - Notification de suppression
   - `notifyAdminsNewCandidature()` - Alerte admin nouvelle candidature
   - `notifyAdminsUpdatedCandidature()` - Alerte admin mise à jour
   - `notifyAdminsDeletedCandidature()` - Alerte admin suppression

3. ✓ Templates d'emails créés en Twig (6 fichiers)
4. ✓ CandidatureController modifié pour envoyer les emails

## 🔧 Configuration finale - Gmail

### Étape 1: Mettre à jour le fichier `.env`

Ouvrez le fichier `.env` et remplacez cette ligne :

```
MAILER_DSN=gmail+smtp://votre-email@gmail.com:votre-code-google@default
```

Par :

```
MAILER_DSN=gmail+smtp://votreemail%40gmail.com:VOTRE-CODE-APP-GOOGLE@default
```

**Remplacez:**
- `votreemail@gmail.com` par votre adresse Gmail (attention: le @ doit être encodé en %40)
- `VOTRE-CODE-APP-GOOGLE` par le code d'application généré par Google

### Exemple d'une configuration complète:
```
MAILER_DSN=gmail+smtp://monentreprise%40gmail.com:abcd efgh ijkl mnop@default
```

---

## 📧 Fonctionnement

### Pour le Client:
1. **Lors de la création d'une candidature** → Email de confirmation
2. **Lors de la modification** → Email de notification
3. **Lors de la suppression** → Email de confirmation

### Pour les Admins (rôle ADMIN_RH):
1. **Nouvelle candidature** → Email d'alerte avec les détails
2. **Modification de candidature** → Email de notification
3. **Suppression de candidature** → Email d'alerte

---

## 🔐 Sécurité - Mot de passe d'application Google

⚠️ **IMPORTANT**: Le code généré par Google est un mot de passe **d'application** et **non votre mot de passe Gmail habituel**.

### Pour générer votre code Google:
1. Allez sur [myaccount.google.com](https://myaccount.google.com)
2. Cliquez sur "Sécurité" dans la barre de gauche
3. Activez "Authentification à 2 facteurs" si ce n'est pas fait
4. Allez à "Mots de passe d'application"
5. Sélectionnez "Mail" et "Windows/Mac/Linux"
6. Copiez le code de 16 caractères généré (sans espaces dans la config ou avec des espaces, ça dépend)

---

## 🧪 Test

Après la configuration, testez en:
1. Créant une nouvelle candidature
2. Vérifiant que l'email est arrivé à votre boîte Gmail
3. Vérifiant que les admins ont reçu les notifications

Si les emails n'arrivent pas, vérifiez:
- Le format du MAILER_DSN
- Que l'authentification à 2 facteurs est activée
- Que le mot de passe d'application est correct
- Les logs Symfony en cas d'erreur

---

## 📝 Fichiers créés/modifiés

### Fichiers créés:
- `config/packages/mailer.yaml` - Configuration du mailer
- `src/Service/EmailService.php` - Service d'envoi d'emails
- `templates/emails/candidature/created.html.twig`
- `templates/emails/candidature/updated.html.twig`
- `templates/emails/candidature/deleted.html.twig`
- `templates/emails/candidature/admin_new.html.twig`
- `templates/emails/candidature/admin_updated.html.twig`
- `templates/emails/candidature/admin_deleted.html.twig`

### Fichiers modifiés:
- `.env` - Ajout de MAILER_DSN
- `src/Controller/CandidatureController.php` - Ajout des appels aux emails

---

## ✨ Personnalisation

Vous pouvez personnaliser les emails en modifiant:
1. L'adresse d'expéditeur dans `src/Service/EmailService.php` (constante `FROM_EMAIL` et `FROM_NAME`)
2. Les templates Twig dans `templates/emails/candidature/`
3. Les sujets des emails dans les méthodes du service

---

**Configuration complète ! 🎉**
