
    <section class="footer">
        <h3>back to top</h3>
        <ul>
            <li><a href="">home</a></li>
            <li><a href="">products</a></li>
            <li><a href="">support</a></li>
            <li><a href="">account</a></li>
            <li><a href="">logout</a></li>
        </ul>
        <p>Copywright Connor Price 2023</p>
    </section>
    <style>
        .footer{
            margin-top: 4em;
            background-color: #060606;
            display: flex;
            flex-direction: column;
            color: gray;
        }

        .footer ul, .footer h3, .footer p{
            list-style: none;
            width: min(1000px, 100%);
            margin-inline: auto;
        }

        .footer h3{
            margin-top: 2em;
        }

        .footer ul li{
            text-align: left;
            margin-block: 1em;
            display: inline-block;
            width: 24%;
            box-sizing: border-box;
        }
    </style>
    <?php
        if (basename($_SERVER['PHP_SELF']) === "login.php"):
    ?>
        <script src="/js/auth/script.js"></script>
    <?php endif; ?>
        <script src="/js/global-script.js"></script>
        <script src="https://js.stripe.com/v3/"></script>
    </body>
</html>