<section id="loginSection">
        <div class="errorMessageDiv mt-2 mb-2"><?= $errorMessage ? $errorMessage : '' ?></div>
<form action="" method="POST">
    <div class="form-group">
        <label for="userName">User Name</label>
        <input type="text" class="form-control" id="userName" name="userName" aria-describedby="username" placeholder="Enter username" required>
    </div>
    <div class="form-group">
        <label for="InputPassword1">Password</label>
        <input type="password" class="form-control" id="userPassword" name="userPassword" placeholder="Password">
    </div>
    <button type="submit" name="submitUser" class="btn btn-primary">Go!</button>
    <br>
    <p class="mt-3">If you have no account, please, <a href="/register">Register</a><p>
</form>
</section>