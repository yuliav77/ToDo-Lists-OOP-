<section id="registerSection">
    <div class="errorMessageDiv"><?= $errorMessage ? $errorMessage : '' ?></div>
    <form action="" method="POST">
        <div class="form-group">
            <label for="userName">User Name</label>
            <input type="text" class="form-control" id="userName" name="userName" aria-describedby="username" placeholder="Enter username" required>
        </div>
        <div class="form-group">
            <label for="userPassword">Password</label>
            <input type="password" class="form-control" id="userPassword" name="userPassword" placeholder="Password">
        </div>
        <button type="submit" name="submitNewUser" class="btn btn-primary">Add account</button>
        <p class="mt-3">If you've already had an account  -> <a href="/login">Login</a></p>
    </form>
</section>
