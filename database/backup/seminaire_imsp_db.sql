-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : ven. 06 juin 2025 à 13:20
-- Version du serveur : 8.0.42-0ubuntu0.24.04.1
-- Version de PHP : 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `seminaire_imsp_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `demande_presentations`
--

CREATE TABLE `demande_presentations` (
  `id` bigint UNSIGNED NOT NULL,
  `presentateur_id` bigint UNSIGNED NOT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_courte` text COLLATE utf8mb4_unicode_ci,
  `document_joint` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `statut` enum('en_attente','accepte','rejete') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en_attente',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `demande_presentations`
--

INSERT INTO `demande_presentations` (`id`, `presentateur_id`, `titre`, `description_courte`, `document_joint`, `statut`, `created_at`, `updated_at`) VALUES
(1, 3, 'CETTE_PRESENTATION', 'CETTE_PRECENTATION EST UNE BELLE PRESENTATIONCETTE_PRECENTATION EST UNE BELLE PRESENTATIONCETTE_PRECENTATION EST UNE BELLE PRESENTATIONCETTE_PRECENTATION EST UNE BELLE PRESENTATIONCETTE_PRECENTATION EST UNE BELLE PRESENTATIONCETTE_PRECENTATION EST UNE BELLE PRESENTATIONCETTE_PRECENTATION EST UNE BELLE PRESENTATIONCETTE_PRECENTATION EST UNE BELLE PRESENTATIONCETTE_PRECENTATION EST UNE BELLE PRESENTATIONCETTE_PRECENTATION EST UNE BELLE PRESENTATIONCETTE_PRECENTATION EST UNE BELLE PRESENTATION', NULL, 'accepte', '2025-06-05 14:45:59', '2025-06-06 11:40:14'),
(2, 3, 'DEUXIODEUXIODEUXIO', 'LA deuxieme presentation LA deuxieme presentation LA deuxieme presentation LA deuxieme presentation LA deuxieme presentation LA deuxieme presentation LA deuxieme presentation LA deuxieme presentation', NULL, 'accepte', '2025-06-05 14:47:44', '2025-06-05 14:48:30'),
(3, 4, 'PRESENTATION_DE_TEST', 'C\'EST UNE DESCRIPTION COURTE C\'EST UNE DESCRIPTION COURTE C\'EST UNE DESCRIPTION COURTE C\'EST UNE DESCRIPTION COURTE C\'EST UNE DESCRIPTION COURTE C\'EST UNE DESCRIPTION COURTE', 'demandes_documents/8V7E588tRiQRvbGomvpwCSJVRySZeMl6aGPSp0Tw.txt', 'en_attente', '2025-06-06 11:43:36', '2025-06-06 11:43:36');

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `failed_jobs`
--

INSERT INTO `failed_jobs` (`id`, `uuid`, `connection`, `queue`, `payload`, `exception`, `failed_at`) VALUES
(1, '6e534867-fd6d-4625-b417-b44101a896c4', 'database', 'default', '{\"uuid\":\"6e534867-fd6d-4625-b417-b44101a896c4\",\"displayName\":\"App\\\\Mail\\\\NouvelleDemandeSoumiseMail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":15:{s:8:\\\"mailable\\\";O:35:\\\"App\\\\Mail\\\\NouvelleDemandeSoumiseMail\\\":3:{s:7:\\\"demande\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:30:\\\"App\\\\Models\\\\DemandePresentation\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:25:\\\"secretaire@seminaire.test\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1749134759,\"delay\":null}', 'Illuminate\\Queue\\TimeoutExceededException: App\\Mail\\NouvelleDemandeSoumiseMail has timed out. in /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Queue/TimeoutExceededException.php:15\nStack trace:\n#0 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(804): Illuminate\\Queue\\TimeoutExceededException::forJob()\n#1 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(218): Illuminate\\Queue\\Worker->timeoutExceededException()\n#2 /home/mondukpe/seminaire-imsp/vendor/symfony/mailer/Transport/Smtp/Stream/SocketStream.php(154): Illuminate\\Queue\\Worker->Illuminate\\Queue\\{closure}()\n#3 [internal function]: Symfony\\Component\\Mailer\\Transport\\Smtp\\Stream\\SocketStream->Symfony\\Component\\Mailer\\Transport\\Smtp\\Stream\\{closure}()\n#4 /home/mondukpe/seminaire-imsp/vendor/symfony/mailer/Transport/Smtp/Stream/SocketStream.php(157): stream_socket_client()\n#5 /home/mondukpe/seminaire-imsp/vendor/symfony/mailer/Transport/Smtp/SmtpTransport.php(279): Symfony\\Component\\Mailer\\Transport\\Smtp\\Stream\\SocketStream->initialize()\n#6 /home/mondukpe/seminaire-imsp/vendor/symfony/mailer/Transport/Smtp/SmtpTransport.php(211): Symfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport->start()\n#7 /home/mondukpe/seminaire-imsp/vendor/symfony/mailer/Transport/AbstractTransport.php(69): Symfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport->doSend()\n#8 /home/mondukpe/seminaire-imsp/vendor/symfony/mailer/Transport/Smtp/SmtpTransport.php(138): Symfony\\Component\\Mailer\\Transport\\AbstractTransport->send()\n#9 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Mail/Mailer.php(584): Symfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport->send()\n#10 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Mail/Mailer.php(331): Illuminate\\Mail\\Mailer->sendSymfonyMessage()\n#11 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Mail/Mailable.php(207): Illuminate\\Mail\\Mailer->send()\n#12 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Support/Traits/Localizable.php(19): Illuminate\\Mail\\Mailable->Illuminate\\Mail\\{closure}()\n#13 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Mail/Mailable.php(200): Illuminate\\Mail\\Mailable->withLocale()\n#14 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Mail/SendQueuedMailable.php(82): Illuminate\\Mail\\Mailable->send()\n#15 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(36): Illuminate\\Mail\\SendQueuedMailable->handle()\n#16 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Container/Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#17 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure()\n#18 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#19 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Container/Container.php(754): Illuminate\\Container\\BoundMethod::call()\n#20 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(132): Illuminate\\Container\\Container->call()\n#21 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(169): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}()\n#22 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(126): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()\n#23 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(136): Illuminate\\Pipeline\\Pipeline->then()\n#24 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(125): Illuminate\\Bus\\Dispatcher->dispatchNow()\n#25 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(169): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}()\n#26 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(126): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()\n#27 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(120): Illuminate\\Pipeline\\Pipeline->then()\n#28 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(68): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware()\n#29 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Queue/Jobs/Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call()\n#30 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(441): Illuminate\\Queue\\Jobs\\Job->fire()\n#31 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(391): Illuminate\\Queue\\Worker->process()\n#32 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(177): Illuminate\\Queue\\Worker->runJob()\n#33 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(148): Illuminate\\Queue\\Worker->daemon()\n#34 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(131): Illuminate\\Queue\\Console\\WorkCommand->runWorker()\n#35 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#36 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Container/Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#37 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure()\n#38 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#39 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Container/Container.php(754): Illuminate\\Container\\BoundMethod::call()\n#40 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Console/Command.php(211): Illuminate\\Container\\Container->call()\n#41 /home/mondukpe/seminaire-imsp/vendor/symfony/console/Command/Command.php(279): Illuminate\\Console\\Command->execute()\n#42 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Console/Command.php(180): Symfony\\Component\\Console\\Command\\Command->run()\n#43 /home/mondukpe/seminaire-imsp/vendor/symfony/console/Application.php(1094): Illuminate\\Console\\Command->run()\n#44 /home/mondukpe/seminaire-imsp/vendor/symfony/console/Application.php(342): Symfony\\Component\\Console\\Application->doRunCommand()\n#45 /home/mondukpe/seminaire-imsp/vendor/symfony/console/Application.php(193): Symfony\\Component\\Console\\Application->doRun()\n#46 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(197): Symfony\\Component\\Console\\Application->run()\n#47 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Foundation/Application.php(1234): Illuminate\\Foundation\\Console\\Kernel->handle()\n#48 /home/mondukpe/seminaire-imsp/artisan(16): Illuminate\\Foundation\\Application->handleCommand()\n#49 {main}', '2025-06-05 15:23:31'),
(2, '68c1da06-9471-47e0-b714-8b73c3fb118c', 'database', 'default', '{\"uuid\":\"68c1da06-9471-47e0-b714-8b73c3fb118c\",\"displayName\":\"App\\\\Mail\\\\NouvelleDemandeSoumiseMail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":15:{s:8:\\\"mailable\\\";O:35:\\\"App\\\\Mail\\\\NouvelleDemandeSoumiseMail\\\":3:{s:7:\\\"demande\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:30:\\\"App\\\\Models\\\\DemandePresentation\\\";s:2:\\\"id\\\";i:2;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:25:\\\"secretaire@seminaire.test\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1749134864,\"delay\":null}', 'Symfony\\Component\\Mailer\\Exception\\TransportException: Failed to authenticate on SMTP server with username \"api\" using the following authenticators: \"LOGIN\", \"PLAIN\". Authenticator \"LOGIN\" returned \"Expected response code \"235\" but got code \"535\", with message \"535 5.7.8 Authentication failed\".\". Authenticator \"PLAIN\" returned \"Expected response code \"235\" but got code \"535\", with message \"535 5.7.8 Authentication failed\".\". in /home/mondukpe/seminaire-imsp/vendor/symfony/mailer/Transport/Smtp/EsmtpTransport.php:247\nStack trace:\n#0 /home/mondukpe/seminaire-imsp/vendor/symfony/mailer/Transport/Smtp/EsmtpTransport.php(177): Symfony\\Component\\Mailer\\Transport\\Smtp\\EsmtpTransport->handleAuth()\n#1 /home/mondukpe/seminaire-imsp/vendor/symfony/mailer/Transport/Smtp/EsmtpTransport.php(134): Symfony\\Component\\Mailer\\Transport\\Smtp\\EsmtpTransport->doEhloCommand()\n#2 /home/mondukpe/seminaire-imsp/vendor/symfony/mailer/Transport/Smtp/SmtpTransport.php(255): Symfony\\Component\\Mailer\\Transport\\Smtp\\EsmtpTransport->executeCommand()\n#3 /home/mondukpe/seminaire-imsp/vendor/symfony/mailer/Transport/Smtp/SmtpTransport.php(281): Symfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport->doHeloCommand()\n#4 /home/mondukpe/seminaire-imsp/vendor/symfony/mailer/Transport/Smtp/SmtpTransport.php(211): Symfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport->start()\n#5 /home/mondukpe/seminaire-imsp/vendor/symfony/mailer/Transport/AbstractTransport.php(69): Symfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport->doSend()\n#6 /home/mondukpe/seminaire-imsp/vendor/symfony/mailer/Transport/Smtp/SmtpTransport.php(138): Symfony\\Component\\Mailer\\Transport\\AbstractTransport->send()\n#7 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Mail/Mailer.php(584): Symfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport->send()\n#8 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Mail/Mailer.php(331): Illuminate\\Mail\\Mailer->sendSymfonyMessage()\n#9 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Mail/Mailable.php(207): Illuminate\\Mail\\Mailer->send()\n#10 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Support/Traits/Localizable.php(19): Illuminate\\Mail\\Mailable->Illuminate\\Mail\\{closure}()\n#11 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Mail/Mailable.php(200): Illuminate\\Mail\\Mailable->withLocale()\n#12 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Mail/SendQueuedMailable.php(82): Illuminate\\Mail\\Mailable->send()\n#13 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(36): Illuminate\\Mail\\SendQueuedMailable->handle()\n#14 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Container/Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#15 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure()\n#16 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#17 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Container/Container.php(754): Illuminate\\Container\\BoundMethod::call()\n#18 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(132): Illuminate\\Container\\Container->call()\n#19 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(169): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}()\n#20 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(126): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()\n#21 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(136): Illuminate\\Pipeline\\Pipeline->then()\n#22 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(125): Illuminate\\Bus\\Dispatcher->dispatchNow()\n#23 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(169): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}()\n#24 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(126): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()\n#25 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(120): Illuminate\\Pipeline\\Pipeline->then()\n#26 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(68): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware()\n#27 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Queue/Jobs/Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call()\n#28 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(441): Illuminate\\Queue\\Jobs\\Job->fire()\n#29 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(391): Illuminate\\Queue\\Worker->process()\n#30 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(177): Illuminate\\Queue\\Worker->runJob()\n#31 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(148): Illuminate\\Queue\\Worker->daemon()\n#32 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(131): Illuminate\\Queue\\Console\\WorkCommand->runWorker()\n#33 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#34 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Container/Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#35 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure()\n#36 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#37 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Container/Container.php(754): Illuminate\\Container\\BoundMethod::call()\n#38 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Console/Command.php(211): Illuminate\\Container\\Container->call()\n#39 /home/mondukpe/seminaire-imsp/vendor/symfony/console/Command/Command.php(279): Illuminate\\Console\\Command->execute()\n#40 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Console/Command.php(180): Symfony\\Component\\Console\\Command\\Command->run()\n#41 /home/mondukpe/seminaire-imsp/vendor/symfony/console/Application.php(1094): Illuminate\\Console\\Command->run()\n#42 /home/mondukpe/seminaire-imsp/vendor/symfony/console/Application.php(342): Symfony\\Component\\Console\\Application->doRunCommand()\n#43 /home/mondukpe/seminaire-imsp/vendor/symfony/console/Application.php(193): Symfony\\Component\\Console\\Application->doRun()\n#44 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(197): Symfony\\Component\\Console\\Application->run()\n#45 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Foundation/Application.php(1234): Illuminate\\Foundation\\Console\\Kernel->handle()\n#46 /home/mondukpe/seminaire-imsp/artisan(16): Illuminate\\Foundation\\Application->handleCommand()\n#47 {main}', '2025-06-05 15:29:00'),
(3, '9486dc6b-e1f6-4e0f-90ff-ca09c55da702', 'database', 'default', '{\"uuid\":\"9486dc6b-e1f6-4e0f-90ff-ca09c55da702\",\"displayName\":\"App\\\\Mail\\\\DemandeValideeMail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":15:{s:8:\\\"mailable\\\";O:27:\\\"App\\\\Mail\\\\DemandeValideeMail\\\":4:{s:7:\\\"demande\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:30:\\\"App\\\\Models\\\\DemandePresentation\\\";s:2:\\\"id\\\";i:2;s:9:\\\"relations\\\";a:1:{i:0;s:12:\\\"presentateur\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:9:\\\"seminaire\\\";N;s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:33:\\\"presentateur.alpha@seminaire.test\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1749134910,\"delay\":null}', 'Illuminate\\Queue\\TimeoutExceededException: App\\Mail\\DemandeValideeMail has timed out. in /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Queue/TimeoutExceededException.php:15\nStack trace:\n#0 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(804): Illuminate\\Queue\\TimeoutExceededException::forJob()\n#1 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(218): Illuminate\\Queue\\Worker->timeoutExceededException()\n#2 /home/mondukpe/seminaire-imsp/vendor/symfony/mailer/Transport/Smtp/Stream/SocketStream.php(154): Illuminate\\Queue\\Worker->Illuminate\\Queue\\{closure}()\n#3 [internal function]: Symfony\\Component\\Mailer\\Transport\\Smtp\\Stream\\SocketStream->Symfony\\Component\\Mailer\\Transport\\Smtp\\Stream\\{closure}()\n#4 /home/mondukpe/seminaire-imsp/vendor/symfony/mailer/Transport/Smtp/Stream/SocketStream.php(157): stream_socket_client()\n#5 /home/mondukpe/seminaire-imsp/vendor/symfony/mailer/Transport/Smtp/SmtpTransport.php(279): Symfony\\Component\\Mailer\\Transport\\Smtp\\Stream\\SocketStream->initialize()\n#6 /home/mondukpe/seminaire-imsp/vendor/symfony/mailer/Transport/Smtp/SmtpTransport.php(211): Symfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport->start()\n#7 /home/mondukpe/seminaire-imsp/vendor/symfony/mailer/Transport/AbstractTransport.php(69): Symfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport->doSend()\n#8 /home/mondukpe/seminaire-imsp/vendor/symfony/mailer/Transport/Smtp/SmtpTransport.php(138): Symfony\\Component\\Mailer\\Transport\\AbstractTransport->send()\n#9 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Mail/Mailer.php(584): Symfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport->send()\n#10 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Mail/Mailer.php(331): Illuminate\\Mail\\Mailer->sendSymfonyMessage()\n#11 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Mail/Mailable.php(207): Illuminate\\Mail\\Mailer->send()\n#12 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Support/Traits/Localizable.php(19): Illuminate\\Mail\\Mailable->Illuminate\\Mail\\{closure}()\n#13 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Mail/Mailable.php(200): Illuminate\\Mail\\Mailable->withLocale()\n#14 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Mail/SendQueuedMailable.php(82): Illuminate\\Mail\\Mailable->send()\n#15 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(36): Illuminate\\Mail\\SendQueuedMailable->handle()\n#16 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Container/Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#17 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure()\n#18 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#19 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Container/Container.php(754): Illuminate\\Container\\BoundMethod::call()\n#20 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(132): Illuminate\\Container\\Container->call()\n#21 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(169): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}()\n#22 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(126): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()\n#23 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(136): Illuminate\\Pipeline\\Pipeline->then()\n#24 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(125): Illuminate\\Bus\\Dispatcher->dispatchNow()\n#25 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(169): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}()\n#26 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(126): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()\n#27 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(120): Illuminate\\Pipeline\\Pipeline->then()\n#28 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(68): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware()\n#29 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Queue/Jobs/Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call()\n#30 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(441): Illuminate\\Queue\\Jobs\\Job->fire()\n#31 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(391): Illuminate\\Queue\\Worker->process()\n#32 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(177): Illuminate\\Queue\\Worker->runJob()\n#33 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(148): Illuminate\\Queue\\Worker->daemon()\n#34 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(131): Illuminate\\Queue\\Console\\WorkCommand->runWorker()\n#35 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#36 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Container/Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#37 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure()\n#38 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#39 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Container/Container.php(754): Illuminate\\Container\\BoundMethod::call()\n#40 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Console/Command.php(211): Illuminate\\Container\\Container->call()\n#41 /home/mondukpe/seminaire-imsp/vendor/symfony/console/Command/Command.php(279): Illuminate\\Console\\Command->execute()\n#42 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Console/Command.php(180): Symfony\\Component\\Console\\Command\\Command->run()\n#43 /home/mondukpe/seminaire-imsp/vendor/symfony/console/Application.php(1094): Illuminate\\Console\\Command->run()\n#44 /home/mondukpe/seminaire-imsp/vendor/symfony/console/Application.php(342): Symfony\\Component\\Console\\Application->doRunCommand()\n#45 /home/mondukpe/seminaire-imsp/vendor/symfony/console/Application.php(193): Symfony\\Component\\Console\\Application->doRun()\n#46 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(197): Symfony\\Component\\Console\\Application->run()\n#47 /home/mondukpe/seminaire-imsp/vendor/laravel/framework/src/Illuminate/Foundation/Application.php(1234): Illuminate\\Foundation\\Console\\Kernel->handle()\n#48 /home/mondukpe/seminaire-imsp/artisan(16): Illuminate\\Foundation\\Application->handleCommand()\n#49 {main}', '2025-06-05 15:30:00');

-- --------------------------------------------------------

--
-- Structure de la table `fichier_presentations`
--

CREATE TABLE `fichier_presentations` (
  `id` bigint UNSIGNED NOT NULL,
  `seminaire_id` bigint UNSIGNED NOT NULL,
  `nom_original_fichier` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `chemin_stockage` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_mime` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `taille_octets` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(4, 'default', '{\"uuid\":\"b8565553-78b8-4012-a071-a5f16cc02931\",\"displayName\":\"App\\\\Mail\\\\DemandeValideeMail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":15:{s:8:\\\"mailable\\\";O:27:\\\"App\\\\Mail\\\\DemandeValideeMail\\\":4:{s:7:\\\"demande\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:30:\\\"App\\\\Models\\\\DemandePresentation\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:1:{i:0;s:12:\\\"presentateur\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:9:\\\"seminaire\\\";N;s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:33:\\\"presentateur.alpha@seminaire.test\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1749210015,\"delay\":null}', 0, NULL, 1749210015, 1749210015),
(5, 'default', '{\"uuid\":\"f57e5232-f2b3-4f6a-8f91-d2939d7369c2\",\"displayName\":\"App\\\\Mail\\\\NouvelleDemandeSoumiseMail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":15:{s:8:\\\"mailable\\\";O:35:\\\"App\\\\Mail\\\\NouvelleDemandeSoumiseMail\\\":3:{s:7:\\\"demande\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:30:\\\"App\\\\Models\\\\DemandePresentation\\\";s:2:\\\"id\\\";i:3;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:25:\\\"secretaire@seminaire.test\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1749210216,\"delay\":null}', 0, NULL, 1749210216, 1749210216);

-- --------------------------------------------------------

--
-- Structure de la table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000001_create_cache_table', 1),
(2, '0001_01_01_000002_create_jobs_table', 1),
(3, '2025_05_19_100000_create_utilisateurs_table', 1),
(4, '2025_05_19_114819_create_demande_presentations_table', 1),
(5, '2025_05_19_114829_create_seminaires_table', 1),
(6, '2025_05_19_122801_create_fichier_presentations_table', 1);

-- --------------------------------------------------------

--
-- Structure de la table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `seminaires`
--

CREATE TABLE `seminaires` (
  `id` bigint UNSIGNED NOT NULL,
  `demande_presentation_id` bigint UNSIGNED DEFAULT NULL,
  `presentateur_id` bigint UNSIGNED DEFAULT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `resume` text COLLATE utf8mb4_unicode_ci,
  `statut` enum('programmé','passé','annulé') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'programmé',
  `date_presentation` date DEFAULT NULL,
  `heure_debut` time DEFAULT NULL,
  `heure_fin` time DEFAULT NULL,
  `lieu` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `seminaires`
--

INSERT INTO `seminaires` (`id`, `demande_presentation_id`, `presentateur_id`, `titre`, `resume`, `statut`, `date_presentation`, `heure_debut`, `heure_fin`, `lieu`, `created_at`, `updated_at`) VALUES
(1, NULL, 3, 'DEUXIODEUXIODEUXIO', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'programmé', '2025-06-10', '10:00:00', '12:00:00', 'IMSP - DANGBO', '2025-06-05 14:50:20', '2025-06-05 14:50:20');

-- --------------------------------------------------------

--
-- Structure de la table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('1BjXHBBpk0bqtXRNpOnVXkTzX0HBzowlFTiylfz2', 1, '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:135.0) Gecko/20100101 Firefox/135.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSHJFeW1LQWg4ekF5eUNIOHVsRjdFNnBtY0NqM0R4YlY3Q0FMWERkaiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1749139728),
('3nSEqGHAmOSa5I6mr3ptMjh46p91ZnsmbHUnek4q', NULL, '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:135.0) Gecko/20100101 Firefox/135.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVWMyYnpmeWI1SHpENjJuc2xjRnpVMFVtQ0lhZFBXb1JpcGFVMlFPbiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1749139288),
('aY8VL8r2yP80C5cx6b8EQLxoLyC0LUihImWMcdsm', NULL, '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:135.0) Gecko/20100101 Firefox/135.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiS25FczFYMm11Zm4xbVhoTFRFYVFMT3l2VVU0VFhGa2NHMlZKVkdlUSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9yZWdpc3RlciI7fX0=', 1749215773),
('mQX0izalwFf8jRjbi6uyBByhKd9yTWHm6bLrRSMz', 5, '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:135.0) Gecko/20100101 Firefox/135.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQWM4b01sOHJ6OEZ6d0p0c0podEtsN0VBWHZJWE1LaFNUU1FhMkVONCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9zZW1pbmFpcmVzIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NTt9', 1749140626);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('etudiant','presentateur','secretaire','admin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'etudiant',
  `recoit_notifications_seminaires` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `recoit_notifications_seminaires`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin Principal', 'admin@seminaire.test', '2025-06-05 14:35:54', '$2y$12$aPBrwdbCJhv1Qb1WXYXHe.ELXtEFtjZAh4Sf6ykD1MhFnz1ZkiE4a', 'admin', 1, 'yWuOqutBZXAoFhyhz5D4j4aEahfH68lQzfeIWCAHi9yBYEJnCKsH2Mq4Xhbi', '2025-06-05 14:35:54', '2025-06-05 14:35:54'),
(2, 'Secrétaire Un', 'secretaire@seminaire.test', '2025-06-05 14:35:54', '$2y$12$YaLL7.eTv.g3gsp1dEyNb.CKhVu10XkUvRmyAG4E0RQciqIYNnKt6', 'secretaire', 1, 'XL5iY3kv5jfstH8lhvE3hUBgwwfKC60oggJUDk8y5GNbhRT5s0fwoNkrHGmw', '2025-06-05 14:35:54', '2025-06-05 14:35:54'),
(3, 'Dr. Présentateur Alpha', 'presentateur.alpha@seminaire.test', '2025-06-05 14:35:54', '$2y$12$nnoK5scI.qPEG5i8qrs6Je1HYTj3XS0DK03Hid3tfQUyuFen6r8xu', 'presentateur', 1, 'w2UcPsKXIXfhi2NtvJU3wYGIoVUHRLDR8EtCHLhORhuls7MbP0rYEvHuipsS', '2025-06-05 14:35:54', '2025-06-05 14:35:54'),
(4, 'Prof. Présentateur Beta', 'presentateur.beta@seminaire.test', '2025-06-05 14:35:55', '$2y$12$fCLj/G3if/QGlbo4QZ6c/OD.OdAxS6BwhAfPVyAhIUFSkeSEtHjYq', 'presentateur', 1, 'FaJC5R6EwNccxVjjcDBIieAEjlkd4ZXTyFYjFovUNNtGMO2EF4T7hTDY7LFs', '2025-06-05 14:35:55', '2025-06-05 14:35:55'),
(5, 'Paulette Da Silva', 'capucine08@example.net', '2025-06-05 14:35:55', '$2y$12$oHAs1KXhB4JzY5O9bVY3N.M04utebYBP6bK1NqZ/N7p.cGG1EOk7e', 'etudiant', 1, 'o4RjIMiUUHzpo6TKVgcnctgo3x4L3qoiLRVesxddAVS8hUWeUOzFbqpLuWX0', '2025-06-05 14:35:55', '2025-06-05 14:35:55'),
(6, 'Thomas Legros', 'xgomez@example.net', '2025-06-05 14:35:55', '$2y$12$oHAs1KXhB4JzY5O9bVY3N.M04utebYBP6bK1NqZ/N7p.cGG1EOk7e', 'etudiant', 1, 'tHyzd0cSZo', '2025-06-05 14:35:55', '2025-06-05 14:35:55'),
(7, 'Alexandre Le Mallet', 'marine72@example.com', '2025-06-05 14:35:55', '$2y$12$oHAs1KXhB4JzY5O9bVY3N.M04utebYBP6bK1NqZ/N7p.cGG1EOk7e', 'etudiant', 1, 'ST9qyd7Km1', '2025-06-05 14:35:55', '2025-06-05 14:35:55'),
(8, 'Michelle Rolland', 'maillot.michele@example.org', '2025-06-05 14:35:55', '$2y$12$oHAs1KXhB4JzY5O9bVY3N.M04utebYBP6bK1NqZ/N7p.cGG1EOk7e', 'etudiant', 1, 'AyDD5uLWD1', '2025-06-05 14:35:55', '2025-06-05 14:35:55'),
(9, 'Luc Lenoir', 'tristan.jacquet@example.com', '2025-06-05 14:35:55', '$2y$12$oHAs1KXhB4JzY5O9bVY3N.M04utebYBP6bK1NqZ/N7p.cGG1EOk7e', 'etudiant', 1, 'xG76vkOjor', '2025-06-05 14:35:55', '2025-06-05 14:35:55'),
(10, 'Étudiant Testeur', 'etudiant.test@seminaire.test', '2025-06-05 14:35:55', '$2y$12$6ngk0Mv/TJ2kKojh76dd8uB2Tg3XWq8sqv8u8y/keeIrMSueAmfcO', 'etudiant', 1, 'kQVtz6XFAX', '2025-06-05 14:35:55', '2025-06-05 14:35:55'),
(11, 'Étudiant Présentateur Potentiel', 'etudiant.presente@seminaire.test', '2025-06-05 14:35:55', '$2y$12$AnDXnmnQCPqKztvdwvuk.OZpqIqvaNP4UzGIM8udQqSSW69vSx1Xu', 'etudiant', 1, 'epOcCcFQ5P', '2025-06-05 14:35:55', '2025-06-05 14:35:55');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Index pour la table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Index pour la table `demande_presentations`
--
ALTER TABLE `demande_presentations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `demande_presentations_presentateur_id_foreign` (`presentateur_id`);

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Index pour la table `fichier_presentations`
--
ALTER TABLE `fichier_presentations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fichier_presentations_seminaire_id_unique` (`seminaire_id`);

--
-- Index pour la table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Index pour la table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Index pour la table `seminaires`
--
ALTER TABLE `seminaires`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seminaires_demande_presentation_id_foreign` (`demande_presentation_id`),
  ADD KEY `seminaires_presentateur_id_foreign` (`presentateur_id`);

--
-- Index pour la table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `utilisateurs_email_unique` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `demande_presentations`
--
ALTER TABLE `demande_presentations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `fichier_presentations`
--
ALTER TABLE `fichier_presentations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `seminaires`
--
ALTER TABLE `seminaires`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `demande_presentations`
--
ALTER TABLE `demande_presentations`
  ADD CONSTRAINT `demande_presentations_presentateur_id_foreign` FOREIGN KEY (`presentateur_id`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `fichier_presentations`
--
ALTER TABLE `fichier_presentations`
  ADD CONSTRAINT `fichier_presentations_seminaire_id_foreign` FOREIGN KEY (`seminaire_id`) REFERENCES `seminaires` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `seminaires`
--
ALTER TABLE `seminaires`
  ADD CONSTRAINT `seminaires_demande_presentation_id_foreign` FOREIGN KEY (`demande_presentation_id`) REFERENCES `demande_presentations` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `seminaires_presentateur_id_foreign` FOREIGN KEY (`presentateur_id`) REFERENCES `utilisateurs` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
