<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite('resources/css/app.css')
    <title>Verify PIN</title>
</head>
<body>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0" style="background: linear-gradient(to bottom, #0074C8, #151A5C);">
        <div class="mt-6 px-10 py-6 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <div>
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="text-[25px] font-medium" id="pinModalLabel">Enter the PIN sent to your email</h5>
                    </div>
                    <div class="modal-body">
                        <form id="pinForm" action="{{ route('verify.pin') }}" method="POST">
                            @csrf
                            <div class="d-flex justify-content-center gap-2 py-6">
                                <!-- Inputs for PIN -->
                                <input type="text" maxlength="1" name="pin[]" class="form-control text-center fs-4 fw-bold pin-input" style="width: 70px; height: 70px; font-size: 32px; padding: 0;" required>
                                <input type="text" maxlength="1" name="pin[]" class="form-control text-center fs-4 fw-bold pin-input" style="width: 70px; height: 70px; font-size: 32px; padding: 0;" required>
                                <input type="text" maxlength="1" name="pin[]" class="form-control text-center fs-4 fw-bold pin-input" style="width: 70px; height: 70px; font-size: 32px; padding: 0;" required>
                                <input type="text" maxlength="1" name="pin[]" class="form-control text-center fs-4 fw-bold pin-input" style="width: 70px; height: 70px; font-size: 32px; padding: 0;" required>
                                <input type="text" maxlength="1" name="pin[]" class="form-control text-center fs-4 fw-bold pin-input" style="width: 70px; height: 70px; font-size: 32px; padding: 0;" required>
                                <input type="text" maxlength="1" name="pin[]" class="form-control text-center fs-4 fw-bold pin-input" style="width: 70px; height: 70px; font-size: 32px; padding: 0;" required>
                            </div>
                            <input type="hidden" name="email" value="{{ session('registration_data')['email'] }}">
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary w-100">Confirm</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.querySelectorAll('.pin-input').forEach((input, index, inputs) => {
            input.addEventListener('input', () => {
                if (input.value && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });
        });
    </script>
</body>
</html>
