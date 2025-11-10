# 🚀 Flutter Integration Guide - Pengaduan Sarpras

Panduan integrasi API Laravel dengan Flutter untuk aplikasi Pengaduan Sarpras.

---

## 📦 Package Dependencies

Tambahkan di `pubspec.yaml`:

```yaml
dependencies:
  flutter:
    sdk: flutter
  
  # HTTP Client
  http: ^1.1.0
  
  # Secure Storage untuk Token
  flutter_secure_storage: ^9.0.0
  
  # State Management (pilih salah satu)
  provider: ^6.1.1
  # atau
  riverpod: ^2.4.9
  
  # Image Picker
  image_picker: ^1.0.4
  
  # Cached Network Image
  cached_network_image: ^3.3.0
  
  # Loading & Toast
  flutter_spinkit: ^5.2.0
  fluttertoast: ^8.2.4
```

---

## 🏗️ Project Structure (Recommended)

```
lib/
├── main.dart
├── config/
│   └── api_config.dart
├── models/
│   ├── user.dart
│   ├── pengaduan.dart
│   ├── lokasi.dart
│   └── barang.dart
├── services/
│   ├── api_service.dart
│   ├── auth_service.dart
│   ├── storage_service.dart
│   └── pengaduan_service.dart
├── providers/
│   ├── auth_provider.dart
│   └── pengaduan_provider.dart
├── screens/
│   ├── auth/
│   │   ├── login_screen.dart
│   │   └── register_screen.dart
│   ├── home/
│   │   └── home_screen.dart
│   ├── profile/
│   │   ├── profile_screen.dart
│   │   └── edit_profile_screen.dart
│   └── pengaduan/
│       ├── create_pengaduan_screen.dart
│       ├── history_screen.dart
│       └── detail_screen.dart
└── widgets/
    ├── custom_button.dart
    ├── custom_text_field.dart
    └── loading_widget.dart
```

---

## 🔧 Configuration

### 1. API Config (`config/api_config.dart`)

```dart
class ApiConfig {
  // Ganti dengan IP server Anda
  static const String baseUrl = 'http://192.168.1.100/pengaduan-sarpas/public/api/v1';
  
  // Endpoints
  static const String register = '$baseUrl/register';
  static const String login = '$baseUrl/login';
  static const String logout = '$baseUrl/logout';
  static const String me = '$baseUrl/me';
  static const String profile = '$baseUrl/profile';
  static const String homepage = '$baseUrl/homepage';
  static const String lokasi = '$baseUrl/lokasi';
  static const String barang = '$baseUrl/barang';
  static const String pengaduan = '$baseUrl/pengaduan';
  static const String pengaduanHistory = '$baseUrl/pengaduan/history';
  
  // Timeout
  static const Duration timeout = Duration(seconds: 30);
}
```

**Note:** 
- Untuk Android Emulator: gunakan `http://10.0.2.2/pengaduan-sarpas/public/api/v1`
- Untuk iOS Simulator: gunakan `http://localhost/pengaduan-sarpas/public/api/v1`
- Untuk Real Device: gunakan IP lokal computer (contoh: `http://192.168.1.100/pengaduan-sarpas/public/api/v1`)

---

## 📱 Models

### User Model (`models/user.dart`)

```dart
class User {
  final int id;
  final String namaPengguna;
  final String username;
  final String role;

  User({
    required this.id,
    required this.namaPengguna,
    required this.username,
    required this.role,
  });

  factory User.fromJson(Map<String, dynamic> json) {
    return User(
      id: json['id'],
      namaPengguna: json['nama_pengguna'],
      username: json['username'],
      role: json['role'],
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'nama_pengguna': namaPengguna,
      'username': username,
      'role': role,
    };
  }
}
```

### Pengaduan Model (`models/pengaduan.dart`)

```dart
class Pengaduan {
  final int id;
  final String lokasi;
  final String barang;
  final String keluhan;
  final String status;
  final bool isTemporaryItem;
  final String? catatanPetugas;
  final String tanggal;
  final String? fotoUrl;

  Pengaduan({
    required this.id,
    required this.lokasi,
    required this.barang,
    required this.keluhan,
    required this.status,
    required this.isTemporaryItem,
    this.catatanPetugas,
    required this.tanggal,
    this.fotoUrl,
  });

  factory Pengaduan.fromJson(Map<String, dynamic> json) {
    return Pengaduan(
      id: json['id'],
      lokasi: json['lokasi'],
      barang: json['barang'],
      keluhan: json['keluhan'],
      status: json['status'],
      isTemporaryItem: json['is_temporary_item'] ?? false,
      catatanPetugas: json['catatan_petugas'],
      tanggal: json['tanggal'],
      fotoUrl: json['foto_url'],
    );
  }
}
```

### Lokasi Model (`models/lokasi.dart`)

```dart
class Lokasi {
  final int id;
  final String namaLokasi;

  Lokasi({
    required this.id,
    required this.namaLokasi,
  });

  factory Lokasi.fromJson(Map<String, dynamic> json) {
    return Lokasi(
      id: json['id_lokasi'],
      namaLokasi: json['nama_lokasi'],
    );
  }
}
```

### Barang Model (`models/barang.dart`)

```dart
class Barang {
  final int id;
  final String namaBarang;
  final String kondisi;

  Barang({
    required this.id,
    required this.namaBarang,
    required this.kondisi,
  });

  factory Barang.fromJson(Map<String, dynamic> json) {
    return Barang(
      id: json['id_barang'],
      namaBarang: json['nama_barang'],
      kondisi: json['kondisi'],
    );
  }
}
```

---

## 🔐 Services

### Storage Service (`services/storage_service.dart`)

```dart
import 'package:flutter_secure_storage/flutter_secure_storage.dart';

class StorageService {
  static const _storage = FlutterSecureStorage();
  static const _keyToken = 'auth_token';
  static const _keyUser = 'user_data';

  // Save token
  static Future<void> saveToken(String token) async {
    await _storage.write(key: _keyToken, value: token);
  }

  // Get token
  static Future<String?> getToken() async {
    return await _storage.read(key: _keyToken);
  }

  // Delete token
  static Future<void> deleteToken() async {
    await _storage.delete(key: _keyToken);
  }

  // Save user data
  static Future<void> saveUser(String userData) async {
    await _storage.write(key: _keyUser, value: userData);
  }

  // Get user data
  static Future<String?> getUser() async {
    return await _storage.read(key: _keyUser);
  }

  // Clear all
  static Future<void> clearAll() async {
    await _storage.deleteAll();
  }
}
```

### API Service (`services/api_service.dart`)

```dart
import 'dart:convert';
import 'package:http/http.dart' as http;
import '../config/api_config.dart';
import 'storage_service.dart';

class ApiService {
  // GET Request
  static Future<Map<String, dynamic>> get(String endpoint) async {
    try {
      final token = await StorageService.getToken();
      final response = await http.get(
        Uri.parse(endpoint),
        headers: {
          'Accept': 'application/json',
          'Authorization': 'Bearer $token',
        },
      ).timeout(ApiConfig.timeout);

      return _handleResponse(response);
    } catch (e) {
      throw Exception('Network error: $e');
    }
  }

  // POST Request
  static Future<Map<String, dynamic>> post(
    String endpoint,
    Map<String, dynamic> body, {
    bool requireAuth = true,
  }) async {
    try {
      final token = await StorageService.getToken();
      final headers = {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
      };

      if (requireAuth && token != null) {
        headers['Authorization'] = 'Bearer $token';
      }

      final response = await http.post(
        Uri.parse(endpoint),
        headers: headers,
        body: jsonEncode(body),
      ).timeout(ApiConfig.timeout);

      return _handleResponse(response);
    } catch (e) {
      throw Exception('Network error: $e');
    }
  }

  // PUT Request
  static Future<Map<String, dynamic>> put(
    String endpoint,
    Map<String, dynamic> body,
  ) async {
    try {
      final token = await StorageService.getToken();
      final response = await http.put(
        Uri.parse(endpoint),
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'Authorization': 'Bearer $token',
        },
        body: jsonEncode(body),
      ).timeout(ApiConfig.timeout);

      return _handleResponse(response);
    } catch (e) {
      throw Exception('Network error: $e');
    }
  }

  // Multipart Request (for file upload)
  static Future<Map<String, dynamic>> multipart(
    String endpoint,
    Map<String, String> fields, {
    String? filePath,
    String fileField = 'foto',
  }) async {
    try {
      final token = await StorageService.getToken();
      final request = http.MultipartRequest('POST', Uri.parse(endpoint));

      request.headers['Authorization'] = 'Bearer $token';
      request.headers['Accept'] = 'application/json';

      // Add fields
      request.fields.addAll(fields);

      // Add file if exists
      if (filePath != null) {
        request.files.add(await http.MultipartFile.fromPath(fileField, filePath));
      }

      final streamedResponse = await request.send().timeout(ApiConfig.timeout);
      final response = await http.Response.fromStream(streamedResponse);

      return _handleResponse(response);
    } catch (e) {
      throw Exception('Network error: $e');
    }
  }

  // Handle response
  static Map<String, dynamic> _handleResponse(http.Response response) {
    final data = jsonDecode(response.body);

    if (response.statusCode >= 200 && response.statusCode < 300) {
      return data;
    } else {
      throw Exception(data['message'] ?? 'Server error');
    }
  }
}
```

### Auth Service (`services/auth_service.dart`)

```dart
import 'dart:convert';
import '../config/api_config.dart';
import '../models/user.dart';
import 'api_service.dart';
import 'storage_service.dart';

class AuthService {
  // Register
  static Future<Map<String, dynamic>> register({
    required String namaPengguna,
    required String username,
    required String password,
    required String passwordConfirmation,
  }) async {
    final response = await ApiService.post(
      ApiConfig.register,
      {
        'nama_pengguna': namaPengguna,
        'username': username,
        'password': password,
        'password_confirmation': passwordConfirmation,
      },
      requireAuth: false,
    );

    if (response['success']) {
      final token = response['data']['token'];
      final user = User.fromJson(response['data']['user']);

      await StorageService.saveToken(token);
      await StorageService.saveUser(jsonEncode(user.toJson()));
    }

    return response;
  }

  // Login
  static Future<Map<String, dynamic>> login({
    required String username,
    required String password,
  }) async {
    final response = await ApiService.post(
      ApiConfig.login,
      {
        'username': username,
        'password': password,
      },
      requireAuth: false,
    );

    if (response['success']) {
      final token = response['data']['token'];
      final user = User.fromJson(response['data']['user']);

      await StorageService.saveToken(token);
      await StorageService.saveUser(jsonEncode(user.toJson()));
    }

    return response;
  }

  // Logout
  static Future<void> logout() async {
    try {
      await ApiService.post(ApiConfig.logout, {});
    } catch (e) {
      // Ignore error
    } finally {
      await StorageService.clearAll();
    }
  }

  // Get current user
  static Future<User?> getCurrentUser() async {
    final userData = await StorageService.getUser();
    if (userData != null) {
      return User.fromJson(jsonDecode(userData));
    }
    return null;
  }

  // Check if logged in
  static Future<bool> isLoggedIn() async {
    final token = await StorageService.getToken();
    return token != null;
  }
}
```

---

## 🎨 Example Screen - Login

```dart
import 'package:flutter/material.dart';
import '../../services/auth_service.dart';

class LoginScreen extends StatefulWidget {
  const LoginScreen({Key? key}) : super(key: key);

  @override
  State<LoginScreen> createState() => _LoginScreenState();
}

class _LoginScreenState extends State<LoginScreen> {
  final _formKey = GlobalKey<FormState>();
  final _usernameController = TextEditingController();
  final _passwordController = TextEditingController();
  bool _isLoading = false;
  bool _obscurePassword = true;

  Future<void> _login() async {
    if (!_formKey.currentState!.validate()) return;

    setState(() => _isLoading = true);

    try {
      final response = await AuthService.login(
        username: _usernameController.text,
        password: _passwordController.text,
      );

      if (response['success']) {
        if (mounted) {
          Navigator.pushReplacementNamed(context, '/home');
        }
      }
    } catch (e) {
      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(content: Text(e.toString())),
        );
      }
    } finally {
      if (mounted) {
        setState(() => _isLoading = false);
      }
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: SafeArea(
        child: Padding(
          padding: const EdgeInsets.all(24.0),
          child: Form(
            key: _formKey,
            child: Column(
              mainAxisAlignment: MainAxisAlignment.center,
              crossAxisAlignment: CrossAxisAlignment.stretch,
              children: [
                const Text(
                  'Login',
                  style: TextStyle(
                    fontSize: 32,
                    fontWeight: FontWeight.bold,
                  ),
                  textAlign: TextAlign.center,
                ),
                const SizedBox(height: 48),
                TextFormField(
                  controller: _usernameController,
                  decoration: const InputDecoration(
                    labelText: 'Username',
                    border: OutlineInputBorder(),
                    prefixIcon: Icon(Icons.person),
                  ),
                  validator: (value) {
                    if (value == null || value.isEmpty) {
                      return 'Username wajib diisi';
                    }
                    return null;
                  },
                ),
                const SizedBox(height: 16),
                TextFormField(
                  controller: _passwordController,
                  obscureText: _obscurePassword,
                  decoration: InputDecoration(
                    labelText: 'Password',
                    border: const OutlineInputBorder(),
                    prefixIcon: const Icon(Icons.lock),
                    suffixIcon: IconButton(
                      icon: Icon(
                        _obscurePassword
                            ? Icons.visibility
                            : Icons.visibility_off,
                      ),
                      onPressed: () {
                        setState(() {
                          _obscurePassword = !_obscurePassword;
                        });
                      },
                    ),
                  ),
                  validator: (value) {
                    if (value == null || value.isEmpty) {
                      return 'Password wajib diisi';
                    }
                    return null;
                  },
                ),
                const SizedBox(height: 24),
                ElevatedButton(
                  onPressed: _isLoading ? null : _login,
                  style: ElevatedButton.styleFrom(
                    padding: const EdgeInsets.symmetric(vertical: 16),
                  ),
                  child: _isLoading
                      ? const CircularProgressIndicator()
                      : const Text('Login'),
                ),
                const SizedBox(height: 16),
                TextButton(
                  onPressed: () {
                    Navigator.pushNamed(context, '/register');
                  },
                  child: const Text('Belum punya akun? Daftar'),
                ),
              ],
            ),
          ),
        ),
      ),
    );
  }

  @override
  void dispose() {
    _usernameController.dispose();
    _passwordController.dispose();
    super.dispose();
  }
}
```

---

## 📸 Example - Create Pengaduan with Image

```dart
import 'dart:io';
import 'package:flutter/material.dart';
import 'package:image_picker/image_picker.dart';
import '../../services/api_service.dart';
import '../../config/api_config.dart';

class CreatePengaduanScreen extends StatefulWidget {
  const CreatePengaduanScreen({Key? key}) : super(key: key);

  @override
  State<CreatePengaduanScreen> createState() => _CreatePengaduanScreenState();
}

class _CreatePengaduanScreenState extends State<CreatePengaduanScreen> {
  final _formKey = GlobalKey<FormState>();
  File? _imageFile;
  int? _selectedLokasiId;
  int? _selectedBarangId;
  final _keluhanController = TextEditingController();
  bool _isLoading = false;

  Future<void> _pickImage() async {
    final picker = ImagePicker();
    final pickedFile = await picker.pickImage(
      source: ImageSource.camera,
      maxWidth: 1024,
      maxHeight: 1024,
      imageQuality: 85,
    );

    if (pickedFile != null) {
      setState(() {
        _imageFile = File(pickedFile.path);
      });
    }
  }

  Future<void> _submit() async {
    if (!_formKey.currentState!.validate()) return;

    setState(() => _isLoading = true);

    try {
      final fields = {
        'id_lokasi': _selectedLokasiId.toString(),
        'id_barang': _selectedBarangId.toString(),
        'keluhan': _keluhanController.text,
      };

      final response = await ApiService.multipart(
        ApiConfig.pengaduan,
        fields,
        filePath: _imageFile?.path,
      );

      if (response['success'] && mounted) {
        Navigator.pop(context);
        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(content: Text('Pengaduan berhasil dibuat')),
        );
      }
    } catch (e) {
      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(content: Text(e.toString())),
        );
      }
    } finally {
      if (mounted) {
        setState(() => _isLoading = false);
      }
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('Buat Pengaduan')),
      body: Form(
        key: _formKey,
        child: ListView(
          padding: const EdgeInsets.all(16),
          children: [
            // Image picker
            GestureDetector(
              onTap: _pickImage,
              child: Container(
                height: 200,
                decoration: BoxDecoration(
                  border: Border.all(color: Colors.grey),
                  borderRadius: BorderRadius.circular(8),
                ),
                child: _imageFile != null
                    ? Image.file(_imageFile!, fit: BoxFit.cover)
                    : const Center(
                        child: Column(
                          mainAxisAlignment: MainAxisAlignment.center,
                          children: [
                            Icon(Icons.camera_alt, size: 48),
                            SizedBox(height: 8),
                            Text('Ambil Foto'),
                          ],
                        ),
                      ),
              ),
            ),
            const SizedBox(height: 16),
            
            // Lokasi dropdown (implement with FutureBuilder)
            // Barang dropdown (implement with FutureBuilder)
            
            TextFormField(
              controller: _keluhanController,
              decoration: const InputDecoration(
                labelText: 'Keluhan',
                border: OutlineInputBorder(),
              ),
              maxLines: 3,
              validator: (value) {
                if (value == null || value.isEmpty) {
                  return 'Keluhan wajib diisi';
                }
                return null;
              },
            ),
            const SizedBox(height: 24),
            ElevatedButton(
              onPressed: _isLoading ? null : _submit,
              child: _isLoading
                  ? const CircularProgressIndicator()
                  : const Text('Submit'),
            ),
          ],
        ),
      ),
    );
  }
}
```

---

## ✅ Testing Checklist

- [ ] Register user baru
- [ ] Login dengan credentials
- [ ] Get homepage data
- [ ] Get lokasi list
- [ ] Get barang by lokasi
- [ ] Create pengaduan (tanpa foto)
- [ ] Create pengaduan (dengan foto)
- [ ] Create pengaduan (temporary item)
- [ ] Get history pengaduan
- [ ] Get detail pengaduan
- [ ] Update profile
- [ ] Change password
- [ ] Logout

---

## 🐛 Common Issues & Solutions

### 1. Connection Refused
**Problem:** `Connection refused` atau `Network error`
**Solution:** 
- Pastikan Laravel server running
- Cek IP address di ApiConfig
- Untuk Android Emulator gunakan `10.0.2.2`
- Untuk real device, pastikan satu network dengan server

### 2. CORS Error
**Problem:** `CORS policy blocked`
**Solution:** Sudah dikonfigurasi di `config/cors.php`

### 3. 401 Unauthorized
**Problem:** Token expired atau invalid
**Solution:** 
- Cek token di storage
- Re-login jika token expired
- Implementasikan auto-refresh token

### 4. Image Upload Failed
**Problem:** File terlalu besar atau format salah
**Solution:**
- Compress image sebelum upload
- Check file extension (jpg, jpeg, png)
- Max size 2MB

---

## 📚 Resources

- [Laravel Sanctum Docs](https://laravel.com/docs/11.x/sanctum)
- [Flutter HTTP Package](https://pub.dev/packages/http)
- [Flutter Secure Storage](https://pub.dev/packages/flutter_secure_storage)
- [Image Picker](https://pub.dev/packages/image_picker)

---

**Happy Coding! 🚀**
