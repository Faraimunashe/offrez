<x-guest-layout>
    <div class="card-body">
        <div class="pt-4 pb-2">
            <p class="text-center small">Register your account credintials.</p>
        </div>
        <x-alert/>
        <form action="{{route('register')}}" method="POST" class="row g-3 needs-validation" novalidate="">
            @csrf

            <div class="col-md-6">
                <label for="yourUsername" class="form-label">Role</label>
                <div class="input-group has-validation">
                    <select name="role" class="form-control" id="yourUsername" required>
                        <option selected disabled>Select Role</option>
                        <option value="student">Student</option>
                        <option value="landlord">Landlord</option>
                    </select>
                    <div class="invalid-feedback">Please enter your role.</div>
                </div>
            </div>
            <div class="col-md-6">
                <label for="yourUsername" class="form-label">Email</label>
                <div class="input-group has-validation">
                    <input type="email" name="email" class="form-control" id="yourUsername" required>
                    <div class="invalid-feedback">Please enter your email.</div>
                </div>
            </div>
            <div class="col-md-6">
                <label for="yourUsername" class="form-label">Firstname</label>
                <div class="input-group has-validation">
                    <input type="text" name="fname" class="form-control" id="yourUsername" required>
                    <div class="invalid-feedback">Please enter your name.</div>
                </div>
            </div>
            <div class="col-md-6">
                <label for="yourUsername" class="form-label">Surname</label>
                <div class="input-group has-validation">
                    <input type="text" name="lname" class="form-control" id="yourUsername" required>
                    <div class="invalid-feedback">Please enter your name.</div>
                </div>
            </div>
            <div class="col-md-6">
                <label for="yourUsername" class="form-label">Gender</label>
                <div class="input-group has-validation">
                    <select name="gender" class="form-control" id="yourUsername" required>
                        <option selected disabled>Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                    <div class="invalid-feedback">Please enter your phone.</div>
                </div>
            </div>
            <div class="col-md-6">
                <label for="yourUsername" class="form-label">Phone</label>
                <div class="input-group has-validation">
                    <input type="tel" name="phone" class="form-control" id="yourUsername" placeholder="0783540959" required>
                    <div class="invalid-feedback">Please enter your phone.</div>
                </div>
            </div>
            <div class="col-md-6">
                <label for="yourPassword" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="yourPassword" required>
                <div class="invalid-feedback">Please enter your password!</div>
            </div>
            <div class="col-md-6">
                <label for="yourPassword" class="form-label">Password Confirmation</label>
                <input type="password" name="password_confirmation" class="form-control" id="yourPassword" required>
                <div class="invalid-feedback">Please enter your password confirmation!</div>
            </div>
            <div class="col-12">
                <button class="btn btn-primary w-100" type="submit">Register</button>
            </div>
            <div class="col-12">
                <p class="small mb-0">Already have an account? <a href="{{route('login')}}">Login</a></p>
            </div>
        </form>
    </div>
</x-guest-layout>
