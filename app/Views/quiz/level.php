<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-10">
        <!-- Header -->
        <div class="game-card p-4 mb-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h3 class="fw-bold text-primary mb-0">
                        <i class="fas fa-gamepad me-2"></i><?= esc($level['level_name']) ?>
                    </h3>
                    <p class="text-muted mb-0"><?= esc($level['level_description']) ?></p>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="score-display d-inline-block">
                        <i class="fas fa-star me-2"></i>
                        <span>Skor: <span id="current-score">0</span> / <?= $totalQuestions ?></span>
                    </div>
                    <div class="ms-3 d-inline-block">
                        <span class="badge bg-info fs-6">
                            <i class="fas fa-clock me-1"></i>
                            <span id="timer">00:00</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Progress Bar -->
        <div class="game-card p-3 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-muted">Progress</span>
                <span class="text-muted"><span id="current-question">1</span> dari <?= $totalQuestions ?></span>
            </div>
            <div class="progress" style="height: 10px;">
                <div class="progress-bar bg-primary" id="progress-bar" style="width: 0%"></div>
            </div>
        </div>

        <!-- Question Container -->
        <div id="question-container">
            <!-- Questions will be loaded here -->
        </div>

        <!-- Result Modal -->
        <div class="modal fade" id="resultModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-trophy me-2"></i>Hasil Permainan
                        </h5>
                    </div>
                    <div class="modal-body text-center">
                        <div id="result-content">
                            <!-- Result will be shown here -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="<?= base_url('quiz') ?>" class="btn btn-primary">Main Lagi</a>
                        <a href="<?= base_url('quiz/leaderboard') ?>" class="btn btn-outline-primary">Lihat Leaderboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
let questions = <?= json_encode($questions) ?>;
let currentQuestionIndex = 0;
let score = 0;
let timer = 0;
let timerInterval;
let startTime = Date.now();

$(document).ready(function() {
    startTimer();
    loadQuestion();
});

function startTimer() {
    timerInterval = setInterval(function() {
        timer++;
        let minutes = Math.floor(timer / 60);
        let seconds = timer % 60;
        $('#timer').text(
            (minutes < 10 ? '0' : '') + minutes + ':' + 
            (seconds < 10 ? '0' : '') + seconds
        );
    }, 1000);
}

function loadQuestion() {
    if (currentQuestionIndex >= questions.length) {
        finishQuiz();
        return;
    }

    let question = questions[currentQuestionIndex];
    let progressPercent = ((currentQuestionIndex + 1) / questions.length) * 100;
    
    $('#current-question').text(currentQuestionIndex + 1);
    $('#progress-bar').css('width', progressPercent + '%');

    let html = `
        <div class="game-card question-card p-4 mb-4">
            <h4 class="fw-bold mb-4">
                <span class="badge bg-primary me-2">${currentQuestionIndex + 1}</span>
                ${question.question_text}
            </h4>
            
            <div class="row">
                <div class="col-12">
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-secondary option-btn text-start p-3" onclick="selectAnswer('a', this)">
                            <strong>A.</strong> ${question.option_a}
                        </button>
                        <button class="btn btn-outline-secondary option-btn text-start p-3" onclick="selectAnswer('b', this)">
                            <strong>B.</strong> ${question.option_b}
                        </button>
                        <button class="btn btn-outline-secondary option-btn text-start p-3" onclick="selectAnswer('c', this)">
                            <strong>C.</strong> ${question.option_c}
                        </button>
                        <button class="btn btn-outline-secondary option-btn text-start p-3" onclick="selectAnswer('d', this)">
                            <strong>D.</strong> ${question.option_d}
                        </button>
                        <button class="btn btn-outline-secondary option-btn text-start p-3" onclick="selectAnswer('e', this)">
                            <strong>E.</strong> ${question.option_e}
                        </button>
                    </div>
                </div>
            </div>
            
            <div id="explanation" class="mt-4" style="display: none;">
                <div class="alert alert-info">
                    <strong>Penjelasan:</strong> <span id="explanation-text"></span>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <button id="next-btn" class="btn btn-primary btn-lg" onclick="nextQuestion()" style="display: none;">
                    <i class="fas fa-arrow-right me-2"></i>Soal Berikutnya
                </button>
            </div>
        </div>
    `;

    $('#question-container').html(html);
}

function selectAnswer(selectedAnswer, button) {
    // Disable all option buttons
    $('.option-btn').prop('disabled', true);
    
    let question = questions[currentQuestionIndex];
    
    // Check answer via AJAX
    $.ajax({
        url: '<?= base_url('quiz/submitAnswer') ?>',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            question_id: question.id,
            selected_answer: selectedAnswer
        }),
        success: function(response) {
            if (response.correct) {
                score++;
                $(button).addClass('correct');
                $('#current-score').text(score);
            } else {
                $(button).addClass('incorrect');
                // Highlight correct answer
                let correctOption = response.correct_answer;
                $('.option-btn').each(function() {
                    let optionText = $(this).text().trim();
                    if (optionText.startsWith(correctOption.toUpperCase() + '.')) {
                        $(this).addClass('correct');
                    }
                });
            }
            
            $('#explanation-text').text(response.explanation);
            $('#explanation').show();
            $('#next-btn').show();
        }
    });
}

function nextQuestion() {
    currentQuestionIndex++;
    loadQuestion();
}

function finishQuiz() {
    clearInterval(timerInterval);
    
    let percentage = Math.round((score / questions.length) * 100);
    let grade = getGrade(percentage);
    
    // Save result
    let playerName = prompt("Masukkan nama Anda untuk leaderboard:", "Anonymous");
    if (!playerName) playerName = "Anonymous";
    
    $.ajax({
        url: '<?= base_url('quiz/saveResult') ?>',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            player_name: playerName,
            level_id: <?= $level['id'] ?>,
            score: score,
            total_questions: questions.length,
            time_taken: timer
        }),
        success: function(response) {
            showResult(grade, percentage);
        }
    });
}

function getGrade(percentage) {
    if (percentage >= 90) return { grade: 'A', class: 'success', icon: 'trophy' };
    if (percentage >= 80) return { grade: 'B', class: 'info', icon: 'medal' };
    if (percentage >= 70) return { grade: 'C', class: 'warning', icon: 'star' };
    if (percentage >= 60) return { grade: 'D', class: 'secondary', icon: 'check' };
    return { grade: 'E', class: 'danger', icon: 'times' };
}

function showResult(grade, percentage) {
    let html = `
        <div class="text-center">
            <i class="fas fa-${grade.icon} fa-4x text-${grade.class} mb-3"></i>
            <h3 class="fw-bold">Selamat!</h3>
            <p class="lead">Anda telah menyelesaikan <?= esc($level['level_name']) ?></p>
            
            <div class="row justify-content-center mt-4">
                <div class="col-md-8">
                    <div class="card border-${grade.class}">
                        <div class="card-header bg-${grade.class} text-white">
                            <h5 class="mb-0">Hasil Anda</h5>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-4">
                                    <h4 class="text-${grade.class}">${score}</h4>
                                    <small class="text-muted">Benar</small>
                                </div>
                                <div class="col-4">
                                    <h4 class="text-${grade.class}">${percentage}%</h4>
                                    <small class="text-muted">Persentase</small>
                                </div>
                                <div class="col-4">
                                    <h4 class="text-${grade.class}">${grade.grade}</h4>
                                    <small class="text-muted">Grade</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    $('#result-content').html(html);
    $('#resultModal').modal('show');
}
</script>
<?= $this->endSection() ?>
