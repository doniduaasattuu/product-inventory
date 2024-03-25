<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="icon" href="/assets/svg/bag-check-fill-svgrepo-com.png"> -->
    <link rel="icon" href="https://codeigniter.com/user_guide/_static/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <!-- Option 1: Include in HTML -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Own script -->
    <script>
        function modalConfirm(url) {
            let modal_url = document.getElementById("modal_url");
            modal_url.setAttribute("href", url);

            modal_button_cancel = document.getElementById("modal_button_cancel");
            modal_button_cancel.onclick = () => {
                modal_url.removeAttribute("href");
            };
        }

        // FILTERING
        function fillInputFilterFromUrlSearchParams(...input_filter) {
            let params = new URLSearchParams(document.location.search);
            if (params.size >= 1) {
                for (const input of input_filter) {
                    let input_from_param = params.get(input.getAttribute("id"));
                    input.value = input_from_param;
                }
            }
        }

        function filterFunction(...input_filter) {
            let params = new URLSearchParams(document.location.search);
            params.delete("page");

            for (const input of input_filter) {
                params.delete(input.getAttribute("id"));
                if (input.value != "") {
                    params.append(input.getAttribute("id"), input.value);
                }
            }

            if (params.size >= 1) {
                window.location = location.pathname + "?" + params.toString();
            } else {
                window.location = location.pathname;
            }
        }

        const debounce = (mainFunction, delay) => {
            // Declare a variable called 'timer' to store the timer ID
            let timer;

            // Return an anonymous function that takes in any number of arguments
            return function(...args) {
                // Clear the previous timer to prevent the execution of 'mainFunction'
                clearTimeout(timer);

                // Set a new timer that will execute 'mainFunction' after the specified delay
                timer = setTimeout(() => {
                    mainFunction(...args);
                }, delay);
            };
        };
        // FILTERING
    </script>

    <title><?= $title ?? getenv('app.name') ?></title>
</head>

<body style="min-width: 330px">

    <?= view('components/navbar') ?>
    <?= view('components/modal-confirm') ?>

    <div class="container-md">
        <div class="py-4">
            <main>
                <?= $this->renderSection('content') ?>
            </main>
        </div>
    </div>
</body>

</html>