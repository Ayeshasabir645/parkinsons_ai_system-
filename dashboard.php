<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include 'db.php';

$success = isset($_GET['success']) ? $_GET['success'] : "";
$error   = "";


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'add') {

    $name   = trim(mysqli_real_escape_string($conn, $_POST['patient_name']));
    $age    = (int) $_POST['age'];
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $tremor = (int) $_POST['tremor_level'];
    $diag   = mysqli_real_escape_string($conn, $_POST['diagnosis']);
    $doctor = trim(mysqli_real_escape_string($conn, $_POST['assigned_doctor']));
    $notes  = trim(mysqli_real_escape_string($conn, $_POST['notes']));

    if (empty($name)) {
        $error = "Please enter patient name.";
    } else {

        $sql = "INSERT INTO patients 
                    (patient_name, age, gender, tremor_level, diagnosis, assigned_doctor, notes)
                VALUES 
                    ('$name', $age, '$gender', $tremor, '$diag', '$doctor', '$notes')";

        if (mysqli_query($conn, $sql)) {
            header("Location: dashboard.php?success=added");
            exit();
        } else {
            $error = "Error: " . mysqli_error($conn);
        }
    }
}
$pos = 0;
$neg = 0;
$pen = 0;

$count_pos = mysqli_query($conn, "SELECT COUNT(*) AS total FROM patients WHERE diagnosis='Positive'");
$pos = mysqli_fetch_assoc($count_pos)['total'];

$count_neg = mysqli_query($conn, "SELECT COUNT(*) AS total FROM patients WHERE diagnosis='Negative'");
$neg = mysqli_fetch_assoc($count_neg)['total'];

$count_pen = mysqli_query($conn, "SELECT COUNT(*) AS total FROM patients WHERE diagnosis='Pending'");
$pen = mysqli_fetch_assoc($count_pen)['total'];
$patients_result = mysqli_query($conn, "SELECT * FROM patients ORDER BY id DESC");
$total           = mysqli_num_rows($patients_result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>Dashboard – Parkinson's AI</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=Playfair+Display:wght@600&display=swap" rel="stylesheet"/>

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
            color: #1a202c;
        }

        nav {
            background: #0f2147;
            color: #ffffff;
            padding: 14px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav .brand {
            font-family: 'Playfair Display', serif;
            font-size: 20px;
        }

        nav .user-info {
            font-size: 13px;
            opacity: 0.85;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        nav a {
            color: #93c5fd;
            text-decoration: none;
            font-size: 13px;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 30px 20px;
        }

        h2 {
            font-size: 22px;
            margin-bottom: 4px;
        }

        .page-sub {
            font-size: 13px;
            color: #718096;
            margin-bottom: 24px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: #ffffff;
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .stat-card .label {
            font-size: 12px;
            color: #718096;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-card .value {
            font-size: 28px;
            font-weight: 700;
        }

        .stat-card.blue   .value { color: #1a56db; }
        .stat-card.red    .value { color: #e53e3e; }
        .stat-card.green  .value { color: #38a169; }
        .stat-card.orange .value { color: #dd6b20; }

        .alert-success {
            background: #f0fff4;
            border: 1px solid #9ae6b4;
            color: #38a169;
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 16px;
            font-size: 13px;
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

        .section-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 14px;
        }

        .card {
            background: #ffffff;
            border-radius: 14px;
            padding: 24px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            margin-bottom: 24px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
        }

        .field-group label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: #1a202c;
            margin-bottom: 5px;
        }

        .field-group input,
        .field-group select,
        .field-group textarea {
            width: 100%;
            padding: 9px 12px;
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

        .btn-add {
            padding: 10px 22px;
            background: #1a56db;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-add:hover {
            background: #1446bc;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f7f8fc;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            color: #718096;
            padding: 12px 14px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        td {
            padding: 12px 14px;
            font-size: 13px;
            border-bottom: 1px solid #e2e8f0;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover td {
            background: #f9fafb;
        }

        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }

        .badge.positive { background: #fed7d7; color: #c53030; }
        .badge.negative { background: #c6f6d5; color: #276749; }
        .badge.pending  { background: #fefcbf; color: #744210; }

        .tremor-bar {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .bar-bg {
            width: 60px;
            height: 6px;
            background: #e2e8f0;
            border-radius: 3px;
            overflow: hidden;
        }

        .bar-fill {
            height: 100%;
            border-radius: 3px;
        }

        .actions {
            display: flex;
            gap: 8px;
        }

        .btn-edit {
            padding: 5px 12px;
            background: #ebf4ff;
            color: #1a56db;
            border: none;
            border-radius: 6px;
            font-size: 12px;
            cursor: pointer;
            text-decoration: none;
            font-weight: 600;
        }

        .btn-del {
            padding: 5px 12px;
            background: #fff5f5;
            color: #e53e3e;
            border: none;
            border-radius: 6px;
            font-size: 12px;
            cursor: pointer;
            text-decoration: none;
            font-weight: 600;
        }

        .btn-edit:hover { background: #bee3f8; }
        .btn-del:hover  { background: #fed7d7; }

        .no-data {
            text-align: center;
            padding: 40px;
            color: #718096;
        }
    </style>
</head>
  ?>
  <div class="stats">
    <div class="stat-card blue">
      <div class="label">Total Patients</div>
      <div class="value"><?= $total ?></div>
    </div>
    <div class="stat-card red">
      <div class="label">Positive Cases</div>
      <div class="value"><?= $pos ?></div>
    </div>
    <div class="stat-card green">
      <div class="label">Negative Cases</div>
      <div class="value"><?= $neg ?></div>
    </div>
    <div class="stat-card orange">
      <div class="label">Pending Review</div>
      <div class="value"><?= $pen ?></div>
    </div>
  </div>

  <div class="card">
    <div class="section-title">➕ Add New Patient </div>
    <form method="POST" action="dashboard.php">
      <input type="hidden" name="action" value="add"/>
      <div class="form-grid">
        <div class="field-group">
          <label>Patient Name *</label>
          <input type="text" name="patient_name" placeholder="Full name" required/>
        </div>
        <div class="field-group">
          <label>Age</label>
          <input type="number" name="age" placeholder="Age" min="1" max="120"/>
        </div>
        <div class="field-group">
          <label>Gender</label>
          <select name="gender">
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
          </select>
        </div>
        <div class="field-group">
          <label>Tremor Level (1–10)</label>
          <input type="number" name="tremor_level" placeholder="1 to 10" min="1" max="10"/>
        </div>
        <div class="field-group">
          <label>Diagnosis</label>
          <select name="diagnosis">
            <option value="Pending">Pending</option>
            <option value="Positive">Positive</option>
            <option value="Negative">Negative</option>
          </select>
        </div>
        <div class="field-group">
          <label>Assigned Doctor</label>
          <input type="text" name="assigned_doctor" placeholder="Dr. Name"/>
        </div>
        <div class="field-group full">
          <label>Notes</label>
          <textarea name="notes" rows="2" placeholder="Any special remarks..."></textarea>
        </div>
      </div>
      <br/>
      <button type="submit" class="btn-add">➕ Add Patient</button>
    </form>
  </div>
  <div class="card">
    <div class="section-title">📋 All Patients</div>
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Age</th>
          <th>Gender</th>
          <th>Tremor</th>
          <th>Diagnosis</th>
          <th>Doctor</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if (mysqli_num_rows($patients_result) == 0): ?>
          <tr><td colspan="8" class="no-data">No patients found. Please add one first!</td></tr>
        <?php else: ?>
          <?php $i = 1; while ($p = mysqli_fetch_assoc($patients_result)): ?>
          <?php
            $diag_class = strtolower($p['diagnosis']);
            $tremor_color = $p['tremor_level'] >= 7 ? '#e53e3e' : ($p['tremor_level'] >= 4 ? '#dd6b20' : '#38a169');
            $bar_width = ($p['tremor_level'] / 10) * 100;
          ?>
          <tr>
            <td><?= $i++ ?></td>
            <td><strong><?= htmlspecialchars($p['patient_name']) ?></strong></td>
            <td><?= $p['age'] ?></td>
            <td><?= $p['gender'] ?></td>
            <td>
              <div class="tremor-bar">
                <?= $p['tremor_level'] ?>/10
                <div class="bar-bg">
                  <div class="bar-fill" style="width:<?= $bar_width ?>%; background:<?= $tremor_color ?>;"></div>
                </div>
              </div>
            </td>
            <td><span class="badge <?= $diag_class ?>"><?= $p['diagnosis'] ?></span></td>
            <td><?= htmlspecialchars($p['assigned_doctor']) ?></td>
            <td>
              <div class="actions">
                <a href="edit_patient.php?id=<?= $p['id'] ?>" class="btn-edit">Edit</a>
                <a href="delete_patient.php?id=<?= $p['id'] ?>" class="btn-del"
                   onclick="return confirm('Are you sure you want to delete this patient?')"> Delete</a>
              </div>
            </td>
          </tr>
          <?php endwhile; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
</body>
</html>