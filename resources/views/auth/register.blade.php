<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Register - KosMatch</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
  <div class="flex items-center justify-center min-h-screen bg-gray-100 py-10">
    <div
      class="relative flex flex-col m-6 space-y-8 bg-white shadow-2xl rounded-2xl md:flex-row md:space-y-0"
    >
      <!-- left side -->
      <div class="flex flex-col justify-center p-8 md:p-14">
        <span class="mb-3 text-4xl font-bold">Daftar KosMatch</span>
        <span class="font-light text-gray-400 mb-8">
          Buat akun untuk mulai mencari atau menawarkan kos
        </span>

        @if ($errors->any())
          <div class="mb-4 p-3 rounded-md bg-red-100 border border-red-300 text-red-700 text-sm">
            <strong class="block mb-1">Terjadi kesalahan:</strong>
            <ul class="mb-0 list-disc list-inside">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
          @csrf

          <div class="py-3">
            <label for="name" class="mb-2 text-md block">Nama</label>
            <input
              type="text"
              id="name"
              name="name"
              value="{{ old('name') }}"
              required
              class="w-full p-2 border border-gray-300 rounded-md placeholder:font-light placeholder:text-gray-500"
            />
          </div>

          <div class="py-3">
            <label for="email" class="mb-2 text-md block">Email</label>
            <input
              type="email"
              id="email"
              name="email"
              value="{{ old('email') }}"
              required
              class="w-full p-2 border border-gray-300 rounded-md placeholder:font-light placeholder:text-gray-500"
            />
          </div>

          <div class="py-3">
            <label for="role" class="mb-2 text-md block">Daftar sebagai</label>
            <select
              name="role"
              id="role"
              required
              class="w-full p-2 border border-gray-300 rounded-md bg-white"
            >
              <option value="">-- Pilih Role --</option>
              <option value="student" {{ old('role') === 'student' ? 'selected' : '' }}>
                Student
              </option>
              <option value="owner" {{ old('role') === 'owner' ? 'selected' : '' }}>
                Owner
              </option>
            </select>
          </div>

          <div class="py-3">
            <label for="password" class="mb-2 text-md block">Password</label>
            <input
              type="password"
              id="password"
              name="password"
              required
              class="w-full p-2 border border-gray-300 rounded-md placeholder:font-light placeholder:text-gray-500"
            />
          </div>

          <div class="py-3">
            <label for="password_confirmation" class="mb-2 text-md block">Konfirmasi Password</label>
            <input
              type="password"
              id="password_confirmation"
              name="password_confirmation"
              required
              class="w-full p-2 border border-gray-300 rounded-md placeholder:font-light placeholder:text-gray-500"
            />
          </div>

          <button
            type="submit"
            class="w-full bg-black text-white p-2 rounded-lg mt-4 mb-6 hover:bg-white hover:text-black hover:border hover:border-gray-300"
          >
            Register
          </button>
        </form>

        <div class="text-center text-gray-400">
          Already have an account?
          <a href="{{ route('login') }}" class="font-bold text-black">Login</a>
        </div>
      </div>

      <!-- right side -->
      <div class="relative">
        <img
          src="{{ asset('images/image.jpg') }}"
          alt="img"
          class="w-[400px] h-full hidden rounded-r-2xl md:block object-cover"
        />
        <div
          class="absolute hidden bottom-10 right-6 p-6 bg-white bg-opacity-30 backdrop-blur-sm rounded drop-shadow-lg md:block"
        >
          <span class="text-white text-xl">
            Temukan kos yang cocok untukmu,<br />
            atau tawarkan kosmu ke ribuan pencari<br />
            hanya lewat KosMatch.
          </span>
        </div>
      </div>
    </div>
  </div>
</body>
</html>