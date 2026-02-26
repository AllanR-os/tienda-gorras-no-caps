<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desert Caps - Tienda de Gorras</title>
    <link rel="icon" type="image/png" href="https://img.freepik.com/vector-premium/plantilla-maquillaje-vectorial-gorra-beisbol-blanca-realista-3d-aislada-sobre-fondo-blanco_272204-23479.jpg?semt=ais_hybrid">

    <style>
        /* Reset y Estilos Base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f1e9;
            color: #4a3c31;
            line-height: 1.6;
        }

        /* Navegación */
        .navbar {
            background-color: #fffcf7;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 5%;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            box-shadow: 0 2px 4px rgba(139, 109, 81, 0.1);
        }

        .logo {
            color: #4a3c31;
            font-size: 1.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .nav-buttons {
            display: flex;
            gap: 1rem;
        }

        .btn {
            text-decoration: none;
            padding: 0.75rem 1.5rem;
            border-radius: 5px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-login {
            background-color: transparent;
            border: 2px solid #8b6d51;
            color: #8b6d51;
        }

        .btn-login:hover {
            background-color: #8b6d51;
            color: #fffcf7;
        }

        .btn-signup {
            background-color: #8b6d51;
            color: #fffcf7;
            border: 2px solid #8b6d51;
        }

        .btn-signup:hover {
            background-color: #6d543f;
            border-color: #6d543f;
        }

        /* Hero Section */
        .hero {
            background-image: url('https://stetson.com/cdn/shop/files/winterEvent_all_1024x.jpg?v=1671751209');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            position: relative;
        }

        .hero-content {
            background-color: rgba(255, 252, 247, 0.3);
            padding: 2.5rem;
            border-radius: 10px;
            max-width: 800px;
            backdrop-filter: blur(5px);
        }

        .hero-content h2 {
            color: white;
            font-size: 3rem;
            margin-bottom: 1rem;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .hero-content p {
            color: white;
            font-size: 1.25rem;
            margin-bottom: 2rem;
        }

        .hero-btn {
            display: inline-block;
            background-color: #8b6d51;
            color: white;
            padding: 1rem 2rem;
            text-decoration: none;
            border-radius: 5px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .hero-btn:hover {
            background-color: #6d543f;
        }

        /* Sección Conócenos */
        .about-us {
            padding: 4rem 5%;
            text-align: center;
            background-color: #f5f1e9;
        }

        .about-us h2 {
            color: #4a3c31;
            font-size: 2rem;
            margin-bottom: 2rem;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .about-us-content {
            max-width: 800px;
            margin: 0 auto;
        }

        .about-us p {
            color: #8b6d51;
            margin-bottom: 1rem;
            line-height: 1.8;
        }

        /* Footer */
        .footer {
            background-color: #4a3c31;
            color: #fffcf7;
            text-align: center;
            padding: 1.25rem;
            font-size: 0.875rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                padding: 1rem;
            }

            .nav-buttons {
                margin-top: 1rem;
            }

            .hero-content h2 {
                font-size: 2rem;
            }

            .hero-content p {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Barra de navegación -->
    <nav class="navbar">
        <div class="logo">NO CAPS</div>
        <div class="nav-buttons">
            <a href="login.php" class="btn btn-login">Iniciar Sesión</a>
            <a href="signup.php" class="btn btn-signup">Registrarse</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h2>Gorras con Alma del Desierto</h2>
            <p>Explora nuestra colección inspirada en el espíritu cowboy</p>
            <a href="login.php" class="hero-btn">iniciar sesion</a>
            <a href="signup.php" class="hero-btn">registrate</a>

        </div>
    </section>

    <!-- Sección Conócenos -->
    <section class="about-us">
        <h2>Conócenos</h2>
        <div class="about-us-content">
            <p>
                En <strong>NO CAPS</strong>, nos inspiramos en la vasta y mística belleza del desierto para crear gorras que capturan el espíritu del cowboy moderno. Desde hace 2 semanas, hemos estado diseñando piezas únicas que combinan estilo, calidad y autenticidad.
            </p>
            <p>
                Cada gorra está hecha con materiales de alta calidad y un diseño cuidado, pensada para acompañarte en tus aventuras, ya sea en la ciudad o en la naturaleza. Nos enorgullece ser una marca que celebra la individualidad y la libertad de expresión.
            </p>
            <p>
                Únete a nuestra comunidad y descubre cómo Desert Caps puede transformar tu estilo con un toque del desierto. ¡Explora nuestras colecciones hoy!
            </p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <p>© 2025 Desert Caps - Todos los derechos reservados</p>
    </footer>
</body>
</html>