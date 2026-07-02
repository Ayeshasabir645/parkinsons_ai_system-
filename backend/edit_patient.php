<?php

session_start();
include 'db.php';

$error = "";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id = (int) $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM patients WHERE id = $id");

if (mysqli_num_rows($result) == 0) {
    header("Location: dashboard.php");
    exit();
}

$patient = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name   = trim(mysqli_real_escape_string($conn, $_POST['patient_name']));
    $age    = (int) $_POST['age'];
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $tremor = (int) $_POST['tremor_level'];
    $diag   = mysqli_real_escape_string($conn, $_POST['diagnosis']);
    $doctor = trim(mysqli_real_escape_string($conn, $_POST['assigned_doctor']));
    $notes  = trim(mysqli_real_escape_string($conn, $_POST['notes']));

    if (empty($name)) {
        $error = "Patient name is required.";

    } else {

        $sql = "UPDATE patients SET
                    patient_name    = '$name',
                    age             = $age,
                    gender          = '$gender',
                    tremor_level    = $tremor,
                    diagnosis       = '$diag',
                    assigned_doctor = '$doctor',
                    notes           = '$notes'
                WHERE id = $id";

        if (mysqli_query($conn, $sql)) {
            header("Location: dashboard.php?success=updated");
            exit();
        } else {
            $error = "Update Error: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>Edit Patient – Parkinson's AI</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet"/>

    <style>

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: #f7f8fc;
            min-height: 100vh;
            padding: 40px 20px;
        }

        .card {
            background: #ffffff;
            border-radius: 16px;
            padding: 36px;
            max-width: 600px;
            margin: 0 auto;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        h2 {
            font-size: 22px;
            color: #0f2147;
            margin-bottom: 6px;
        }

        .sub {
            font-size: 13px;
            color: #718096;
            margin-bottom: 24px;
        }

        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            background: #ebf4ff;
            color: #1a56db;
        }

        .alert-error {
            background: #fff5f5;
            border: 1px solid #fed7d7;
            color: #e53e3e;
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 16px;
            font-size: 13px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .field-group label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 5px;
            color: #1a202c;
        }

        .field-group input,
        .field-group select,
        .field-group textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            font-size: 13px;
            outline: none;
            font-family: inherit;
            transition: border 0.2s;
        }

        .field-group input:focus,
        .field-group select:focus,
        .field-group textarea:focus {
            border-color: #1a56db;
        }

        .field-group.full {
            grid-column: 1 / -1;
        }

        .btn-row {
            display: flex;
            gap: 12px;
            margin-top: 20px;
        }

        .btn-save {
            padding: 11px 24px;
            background: #1a56db;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-save:hover {
            background: #1446bc;
        }

        .btn-cancel {
            padding: 11px 24px;
            background: #edf2f7;
            color: #1a202c;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: background 0.2s;
        }

        .btn-cancel:hover {
            background: #e2e8f0;
        }

    </style>
</head>
<body>

<div class="card">

    <h2>Edit Patient (UPDATE)</h2>
    <p class="sub">
        ID #<?= $id ?> —
        <span class="badge"><?= htmlspecialchars($patient['patient_name']) ?></span>
    </p>

    <?php if (!empty($error)): ?>
        <div class="alert-error"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" action="edit_patient.php?id=<?= $id ?>">

        <div class="form-grid">

            <div class="field-group">
                <label>Patient Name *</label>
                <input type="text" name="patient_name"
                       value="<?= htmlspecialchars($patient['patient_name']) ?>" required/>
            </div>

            <div class="field-group">
                <label>Age</label>
                <input type="number" name="age"
                       value="<?= $patient['age'] ?>" min="1" max="120"/>
            </div>

            <div class="field-group">
                <label>Gender</label>
                <select name="gender">
                    <option value="Male"   <?= $patient['gender'] == 'Male'   ? 'selected' : '' ?>>Male</option>
                    <option value="Female" <?= $patient['gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
                    <option value="Other"  <?= $patient['gender'] == 'Other'  ? 'selected' : '' ?>>Other</option>
                </select>
            </div>

            <div class="field-group">
                <label>Tremor Level (1–10)</label>
                <input type="number" name="tremor_level"
                       value="<?= $patient['tremor_level'] ?>" min="1" max="10"/>
            </div>

            <div class="field-group">
                <label>Diagnosis</label>
                <select name="diagnosis">
                    <option value="Pending"  <?= $patient['diagnosis'] == 'Pending'  ? 'selected' : '' ?>>Pending</option>
                    <option value="Positive" <?= $patient['diagnosis'] == 'Positive' ? 'selected' : '' ?>>Positive</option>
                    <option value="Negative" <?= $patient['diagnosis'] == 'Negative' ? 'selected' : '' ?>>Negative</option>
                </select>
            </div>

            <div class="field-group">
                <label>Assigned Doctor</label>
                <input type="text" name="assigned_doctor"
                       value="<?= htmlspecialchars($patient['assigned_doctor']) ?>"/>
            </div>

            <div class="field-group full">
                <label>Notes</label>
                <textarea name="notes" rows="3"><?= htmlspecialchars($patient['notes']) ?></textarea>
            </div>

        </div>

        <div class="btn-row">
            <button type="submit" class="btn-save">Save Changes</button>
            <a href="dashboard.php" class="btn-cancel">Cancel</a>
        </div>

    </form>

</div>

</body>
</html>
