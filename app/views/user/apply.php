<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply as Organizer</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            display: flex;
            width: 90%;
            max-width: 1000px;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            gap: 20px;
        }

        .form-section, .preview-section {
            width: 50%;
        }

        h1 {
            font-size: 1.8em;
            margin-bottom: 15px;
            color: #0073e6;
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-size: 0.9em;
            margin-bottom: 5px;
            color: #333;
        }

        input, textarea, select {
            font-size: 0.9em;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
            box-sizing: border-box;
        }

        input:focus, textarea:focus, select:focus {
            border-color: #0073e6;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 115, 230, 0.5);
        }

        textarea {
            resize: none;
        }

        button {
            padding: 10px;
            background-color: #0073e6;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 0.9em;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #005bb5;
        }

        .preview-section {
            background: #f7f7f7;
            padding: 15px;
            border-radius: 10px;
            box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.1);
            font-size: 0.85em;
            overflow-y: auto;
            max-height: 400px;
        }

        .preview-section h2 {
            font-size: 1.4em;
            color: #333;
            margin-bottom: 15px;
            text-align: center;
        }

        .preview-section .field {
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .preview-section .field span {
            font-weight: bold;
            color: #555;
        }

        .preview-picture {
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        .preview-picture img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 10px;
            border: 2px solid #ccc;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Form Section -->
        <div class="form-section">
            <h1>Apply as an Organizer</h1>
            <form action="<?= site_url('/user/apply_as_organizer/'); ?>" method="POST" enctype="multipart/form-data">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your full name" oninput="updatePreview()" required>

                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="Enter your email address" oninput="updatePreview()" required>

                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" oninput="updatePreview()" required>

                <label for="experience">Experience in Organizing Events</label>
                <textarea id="experience" name="experience" rows="4" placeholder="Describe your experience in organizing events" oninput="updatePreview()" required></textarea>

                <label for="event-type">Type of Events You Specialize In</label>
                <select id="event-type" name="event_type" onchange="updatePreview()" required>
                    <option value="" disabled selected>Select an option</option>
                    <option value="Conferences">Conferences</option>
                    <option value="Workshops">Workshops</option>
                    <option value="Concerts">Concerts</option>
                    <option value="Sports">Sports</option>
                    <option value="Others">Others</option>
                </select>

                <label for="picture">Upload Your Picture</label>
                <input type="file" id="picture" name="picture" accept="image/*" onchange="updatePicturePreview(event)" required>

                <button type="submit">Submit Application</button>
            </form>
        </div>

        <!-- Preview Section -->
        <div class="preview-section">
            <h2>Application Preview</h2>
            <div class="preview-picture">
                <span>Uploaded Picture:</span>
                <div id="preview-picture"><img src="" alt="No picture uploaded"></div>
            </div>
            <div class="field"><span>Full Name:</span> <span id="preview-name">N/A</span></div>
            <div class="field"><span>Email Address:</span> <span id="preview-email">N/A</span></div>
            <div class="field"><span>Phone Number:</span> <span id="preview-phone">N/A</span></div>
            <div class="field"><span>Experience:</span> <span id="preview-experience">N/A</span></div>
            <div class="field"><span>Event Type:</span> <span id="preview-event-type">N/A</span></div>
        </div>
    </div>

    <script>
        function updatePreview() {
            document.getElementById('preview-name').textContent = document.getElementById('name').value || 'N/A';
            document.getElementById('preview-email').textContent = document.getElementById('email').value || 'N/A';
            document.getElementById('preview-phone').textContent = document.getElementById('phone').value || 'N/A';
            document.getElementById('preview-experience').textContent = document.getElementById('experience').value || 'N/A';
            document.getElementById('preview-event-type').textContent = document.getElementById('event-type').value || 'N/A';
        }

        function updatePicturePreview(event) {
            const picturePreview = document.getElementById('preview-picture');
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    picturePreview.innerHTML = `<img src="${e.target.result}" alt="Uploaded Picture">`;
                };
                reader.readAsDataURL(file);
            } else {
                picturePreview.innerHTML = '<img src="" alt="No picture uploaded">';
            }
        }
    </script>
</body>
</html>
