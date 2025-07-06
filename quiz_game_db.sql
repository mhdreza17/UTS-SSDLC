-- Buat database
CREATE DATABASE quiz_game_db;
USE quiz_game_db;

-- Tabel untuk menyimpan level/kategori quiz
CREATE TABLE levels (
    id INT AUTO_INCREMENT PRIMARY KEY,
    level_name VARCHAR(100) NOT NULL,
    level_description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel untuk menyimpan soal-soal quiz
CREATE TABLE questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    level_id INT,
    question_text TEXT NOT NULL,
    option_a VARCHAR(255) NOT NULL,
    option_b VARCHAR(255) NOT NULL,
    option_c VARCHAR(255) NOT NULL,
    option_d VARCHAR(255) NOT NULL,
    option_e VARCHAR(255) NOT NULL,
    correct_answer CHAR(1) NOT NULL,
    explanation TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (level_id) REFERENCES levels(id)
);

-- Tabel untuk menyimpan hasil permainan
CREATE TABLE game_results (
    id INT AUTO_INCREMENT PRIMARY KEY,
    player_name VARCHAR(100),
    level_id INT,
    score INT DEFAULT 0,
    total_questions INT DEFAULT 0,
    time_taken INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (level_id) REFERENCES levels(id)
);

-- Insert data level
INSERT INTO levels (level_name, level_description) VALUES 
('Level 1', 'Dasar-Dasar Keamanan Perangkat Lunak'),
('Level 2', 'Tahapan dan Biaya dalam SSDLC');

-- Insert soal Level 1
INSERT INTO questions (level_id, question_text, option_a, option_b, option_c, option_d, option_e, correct_answer, explanation) VALUES 
(1, 'Apa tujuan utama dari Software Security?', 'Melindungi aplikasi setelah dirilis', 'Membangun perangkat lunak yang aman sejak awal', 'Menyusun dokumentasi pengguna', 'Mengoptimalkan performa sistem', 'Meningkatkan jumlah pengguna aplikasi', 'b', 'Software Security bertujuan membangun perangkat lunak yang aman sejak awal pengembangan'),

(1, 'Manakah yang merupakan definisi dari Application Security?', 'Membangun sistem dengan enkripsi dari awal', 'Melakukan patch keamanan setelah rilis produk', 'Mencegah eksploitasi melalui desain arsitektur', 'Melakukan penetration testing saat coding', 'Memastikan keamanan infrastruktur jaringan', 'b', 'Application Security fokus pada patch keamanan setelah produk dirilis'),

(1, 'Apa itu SSDLC (Secure Software Development Life Cycle)?', 'Model pengembangan perangkat lunak tanpa testing', 'Proses pengembangan perangkat lunak dengan integrasi keamanan di setiap fase', 'Metode untuk mengevaluasi biaya produksi', 'Teknik analisis data pelanggan', 'Panduan untuk membuat antarmuka pengguna yang ramah', 'b', 'SSDLC mengintegrasikan keamanan di setiap fase pengembangan'),

(1, 'Mengapa penting membangun keamanan sejak awal pengembangan perangkat lunak?', 'Agar lebih cepat selesai', 'Agar lebih mudah dijual', 'Untuk mengurangi biaya perbaikan masalah keamanan di akhir', 'Agar bisa mendapat sertifikasi internasional', 'Agar tampilannya lebih menarik', 'c', 'Membangun keamanan sejak awal mengurangi biaya perbaikan di kemudian hari'),

(1, 'Berikut ini adalah contoh ancaman jika tidak menerapkan SSDLC, kecuali...', 'SQL Injection', 'Buffer Overflow', 'Desain UI yang menarik', 'Data Breach', 'Cross-site Scripting (XSS)', 'c', 'Desain UI yang menarik bukan merupakan ancaman keamanan');

-- Insert soal Level 2
INSERT INTO questions (level_id, question_text, option_a, option_b, option_c, option_d, option_e, correct_answer, explanation) VALUES 
(2, 'Di mana biaya penanganan kerentanan paling murah menurut studi IBM?', 'Setelah rilis produk', 'Saat implementasi kode', 'Saat pengujian (testing)', 'Saat fase desain', 'Saat pemeliharaan', 'd', 'Biaya penanganan kerentanan paling murah saat fase desain'),

(2, 'Berapa persentase ROI (Return of Security Investment) tertinggi jika kerentanan diperbaiki sejak fase desain?', '$12,000 per $100,000', '$15,000 per $100,000', '$21,000 per $100,000', '$30,000 per $100,000', '$50,000 per $100,000', 'c', 'ROI tertinggi adalah $21,000 per $100,000 jika diperbaiki sejak fase desain'),

(2, 'Apa salah satu metode pengujian keamanan dalam SSDLC?', 'Unit Testing', 'Penetration Testing', 'Smoke Testing', 'Regression Testing', 'Integration Testing', 'b', 'Penetration Testing adalah metode pengujian keamanan dalam SSDLC'),

(2, 'Apa yang dimaksud dengan "post-development security"?', 'Pengamanan sebelum pengembangan', 'Pengamanan selama coding', 'Pengamanan setelah software jadi', 'Pengamanan saat desain arsitektur', 'Pengamanan saat perencanaan proyek', 'c', 'Post-development security adalah pengamanan setelah software selesai dibuat'),

(2, 'Salah satu model SSDLC yang dikembangkan oleh Microsoft adalah...', 'CLASP', 'SDL (Security Development Lifecycle)', 'Touchpoint', 'Waterfall', 'Agile', 'b', 'SDL (Security Development Lifecycle) adalah model SSDLC dari Microsoft');
