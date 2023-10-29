<?php
include('../connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data from the form
    $date = $_POST['date'];
    $amount = floatval($_POST['amount']);
    $toAccount = $_POST['to_account'];
    $comment = $_POST['comment'];

    // Start a transaction
    $conn->begin_transaction();

    try {
        // Get current remaining amount from cashathand
        $balanceResult = $conn->query("SELECT amount FROM cashathand FOR UPDATE");
        $balanceRow = $balanceResult->fetch_assoc();
        $remainingCashAtHand = $balanceRow ? $balanceRow['amount'] : 0;

        // Check if there's enough cash at hand for the transfer
        if ($remainingCashAtHand < $amount) {
            throw new Exception("Not enough cash at hand for the transfer.");
        }

        // Calculate remaining cash at hand after transfer
        $remainingCashAtHand -= $amount;

        // Update remaining cash in cashathand table
        $updateCashBalance = $conn->prepare("UPDATE cashathand SET amount = ?");
        $updateCashBalance->bind_param("d", $remainingCashAtHand);
        $updateCashBalance->execute();

        // Update Bank Account: Add the transferred amount
        $updateBankAccount = $conn->prepare("UPDATE bankaccounts SET amount = amount + ? WHERE account_name = ?");
        $updateBankAccount->bind_param("ds", $amount, $toAccount);
        $updateBankAccount->execute();

        // Insert transaction details into the cashtransfers table
        $insertTransaction = $conn->prepare("INSERT INTO cashtransfers (date, amount, to_account, comment) VALUES (?, ?, ?, ?)");
        $insertTransaction->bind_param("sdss", $date, $amount, $toAccount, $comment);
        $insertTransaction->execute();

        // Commit the transaction
        $conn->commit();

        // Redirect to a success page or display a success message with remaining cash at hand
        $successMessage = "Cash transferred successfully! Remaining cash at hand: $remainingCashAtHand";
        header("Location: cashaccounts.php?successMessage=$successMessage");
        exit();
    } catch (Exception $e) {
        // Rollback the transaction in case of an error
        $conn->rollback();

        // Handle the error, you can redirect to an error page or display an error message
        $errorMessage = $e->getMessage();
        header("Location: cashaccounts.php?errorMessage=$errorMessage");
        exit();
    }
}
?>
