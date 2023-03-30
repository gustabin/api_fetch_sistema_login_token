-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 30, 2023 at 05:44 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `usuario`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `correo` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `token` varchar(100) COLLATE utf8mb4_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nombre`, `correo`, `password`, `token`) VALUES
(1, 'Gustavo Arias', 'gustabin@yahoo.com', '$2y$10$/mQoQ4Po1uUuDPFyHnPfSeTcrUEBCjgkGSid54yuyIsbulFPFKE.S', 'd61571c4edf85c52ec82e145f13a4af6e5bc62b7f0ae61ec544f3c0ca33293fa'),
(2, 'Oscar D\' Leon', 'oscar@dleon.com', '$2y$10$bJNOdU7PugmR2ROee7PYbOa48y0O1qtWr8Ghba.HEpc5515fDY6yO', ''),
(3, 'Ruben Blades', 'ruben@blades.com', '$2y$10$ZW3XnnBi/Oc6XsajQ.ElAuKRNKyDnUuwXOSAsuH3s17Fiq3WzPxOO', '6c720b9eeafd78b8cd4695a58531e90c1b2d81d526aa7f3151d9ac990b067d75'),
(4, 'Celia Cruz', 'celia@cruz.com', '$2y$10$h1ciFDsBKz7KnHUX/BJCAOOagCyNXF/sPohJHjqmJdl.932cop756', NULL),
(5, 'Ismael Rivera', 'maelo@rivera.com', '$2y$10$7NNQ9D/dhvhLqx9SNTEVNeb6TvC8WycDwnaHYlkXxfJUoaBJcUC26', NULL),
(6, 'Gilberto Santa Rosa', 'gilberto@santarosa.com', '$2y$10$kbC4xr.iHjNZJCrX.sv8WOROXL5o8DYcQmF8FvkhoSCS9FqYSncmq', 'b0cdc02b994f137bd410de3ddf58f458b9f1a196113211f18cba6220b6fa8300'),
(7, 'Tito Puentes', 'tito@puentes.com', '$2y$10$r3hRn49MqkSu3bP2zeZcYeJe4IGatNTR5g5j2i9dnlvjSK4STq/Sm', NULL),
(8, 'Johnny Pacheco', 'johnny@pacheco.com', '$2y$10$Vjvj8yQbnvj/A8IFyfqysOyPYza7C10hNDj0F8VyuiprGegoWqYsi', NULL),
(9, 'Cheo Feliciano', 'cheo@feliciano.com', '$2y$10$3rHk8CKW51BP0oZAcN9t3uXzoLzmKO89JJ/ceQeTBrUv.9ZPfTueO', NULL),
(10, 'Gustavo Arias', 'admin@yahoo.com', '$2y$10$zHwzGwRYRu4hfG1JrPwfuegWMAkiN/T5mi50A9ptpvy6n.PvCgoOG', NULL),
(12, 'Felipe Rojas', 'superceo@gmail.com', '$2y$10$YKV7Hd.4kI7w6neBahfcpeuDXM3vv7cjVkgTsFKRVASvSjrjhm3V.', '78ebf0f215b32fc41d518d17b8ab3e2af9e5d56a497c4311581d66f6e13560a4');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
