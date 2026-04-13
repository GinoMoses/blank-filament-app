<?php

namespace Database\Seeders;

use App\DifficultyLevel;
use App\Models\ExamTest;
use App\Models\Question;
use App\Models\QuestionAnswer;
use App\Models\QuestionCategory;
use App\Models\User;
use Illuminate\Database\Seeder;

class ExamQuestionBankSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin User', 'password' => bcrypt('password')]
        );

        $student = User::firstOrCreate(
            ['email' => 'student@example.com'],
            ['name' => 'Test Student', 'password' => bcrypt('password')]
        );

        $categories = [
            'Mathematics' => [
                'description' => 'Basic and advanced mathematics questions',
                'questions' => [
                    [
                        'question' => 'Ile wynosi suma kątów wewnętrznych trójkąta?',
                        'difficulty' => DifficultyLevel::Easy,
                        'explanation' => 'Suma kątów wewnętrznych trójkąta zawsze wynosi 180 stopni.',
                        'answers' => [
                            ['answer' => '180°', 'correct' => true],
                            ['answer' => '360°', 'correct' => false],
                            ['answer' => '90°', 'correct' => false],
                            ['answer' => '270°', 'correct' => false],
                        ],
                    ],
                    [
                        'question' => 'Ile to jest 15% z 200?',
                        'difficulty' => DifficultyLevel::Easy,
                        'explanation' => '15% z 200 = 0.15 × 200 = 30',
                        'answers' => [
                            ['answer' => '30', 'correct' => true],
                            ['answer' => '15', 'correct' => false],
                            ['answer' => '20', 'correct' => false],
                            ['answer' => '25', 'correct' => false],
                        ],
                    ],
                    [
                        'question' => 'Rozwiąż równanie: 2x + 5 = 15',
                        'difficulty' => DifficultyLevel::Easy,
                        'explanation' => '2x + 5 = 15 → 2x = 10 → x = 5',
                        'answers' => [
                            ['answer' => 'x = 5', 'correct' => true],
                            ['answer' => 'x = 10', 'correct' => false],
                            ['answer' => 'x = 7.5', 'correct' => false],
                            ['answer' => 'x = 2.5', 'correct' => false],
                        ],
                    ],
                    [
                        'question' => 'Ile wynosi pole koła o promieniu 7 cm (π ≈ 3.14)?',
                        'difficulty' => DifficultyLevel::Medium,
                        'explanation' => 'Pole koła = πr² = 3.14 × 7² = 3.14 × 49 = 153.86 cm²',
                        'answers' => [
                            ['answer' => '153.86 cm²', 'correct' => true],
                            ['answer' => '43.96 cm²', 'correct' => false],
                            ['answer' => '21.98 cm²', 'correct' => false],
                            ['answer' => '307.72 cm²', 'correct' => false],
                        ],
                    ],
                    [
                        'question' => 'Oblicz pierwiastek kwadratowy z 144.',
                        'difficulty' => DifficultyLevel::Easy,
                        'explanation' => '√144 = 12, ponieważ 12 × 12 = 144',
                        'answers' => [
                            ['answer' => '12', 'correct' => true],
                            ['answer' => '14', 'correct' => false],
                            ['answer' => '11', 'correct' => false],
                            ['answer' => '24', 'correct' => false],
                        ],
                    ],
                    [
                        'question' => 'Ile wynosi obwód prostokąta o bokach 8 cm i 12 cm?',
                        'difficulty' => DifficultyLevel::Easy,
                        'explanation' => 'Obwód = 2(a+b) = 2(8+12) = 40 cm',
                        'answers' => [
                            ['answer' => '40 cm', 'correct' => true],
                            ['answer' => '96 cm', 'correct' => false],
                            ['answer' => '20 cm', 'correct' => false],
                            ['answer' => '80 cm', 'correct' => false],
                        ],
                    ],
                    [
                        'question' => 'Która z liczb jest liczbą pierwszą?',
                        'difficulty' => DifficultyLevel::Medium,
                        'explanation' => 'Liczba pierwsza dzieli się tylko przez 1 i siebie. 17 jest liczbą pierwszą.',
                        'answers' => [
                            ['answer' => '17', 'correct' => true],
                            ['answer' => '15', 'correct' => false],
                            ['answer' => '21', 'correct' => false],
                            ['answer' => '27', 'correct' => false],
                        ],
                    ],
                    [
                        'question' => 'Oblicz: 3² + 4²',
                        'difficulty' => DifficultyLevel::Easy,
                        'explanation' => '3² + 4² = 9 + 16 = 25',
                        'answers' => [
                            ['answer' => '25', 'correct' => true],
                            ['answer' => '49', 'correct' => false],
                            ['answer' => '81', 'correct' => false],
                            ['answer' => '7', 'correct' => false],
                        ],
                    ],
                    [
                        'question' => 'Ile wynosi objętość sześcianu o boku 5 cm?',
                        'difficulty' => DifficultyLevel::Medium,
                        'explanation' => 'Objętość sześcianu = a³ = 5³ = 125 cm³',
                        'answers' => [
                            ['answer' => '125 cm³', 'correct' => true],
                            ['answer' => '25 cm³', 'correct' => false],
                            ['answer' => '150 cm³', 'correct' => false],
                            ['answer' => '100 cm³', 'correct' => false],
                        ],
                    ],
                    [
                        'question' => 'Rozwiąż nierówność: 3x - 6 > 12',
                        'difficulty' => DifficultyLevel::Medium,
                        'explanation' => '3x - 6 > 12 → 3x > 18 → x > 6',
                        'answers' => [
                            ['answer' => 'x > 6', 'correct' => true],
                            ['answer' => 'x > 2', 'correct' => false],
                            ['answer' => 'x < 6', 'correct' => false],
                            ['answer' => 'x > 18', 'correct' => false],
                        ],
                    ],
                    [
                        'question' => 'Oblicz średnią arytmetyczną liczb: 4, 8, 12, 16, 20',
                        'difficulty' => DifficultyLevel::Easy,
                        'explanation' => 'Średnia = (4+8+12+16+20)/5 = 60/5 = 12',
                        'answers' => [
                            ['answer' => '12', 'correct' => true],
                            ['answer' => '10', 'correct' => false],
                            ['answer' => '14', 'correct' => false],
                            ['answer' => '11', 'correct' => false],
                        ],
                    ],
                    [
                        'question' => 'Ile wynosi tangens kąta 45°?',
                        'difficulty' => DifficultyLevel::Medium,
                        'explanation' => 'tan(45°) = 1, ponieważ sin(45°)/cos(45°) = 1',
                        'answers' => [
                            ['answer' => '1', 'correct' => true],
                            ['answer' => '0', 'correct' => false],
                            ['answer' => '√2', 'correct' => false],
                            ['answer' => '∞', 'correct' => false],
                        ],
                    ],
                ],
            ],
            'English' => [
                'description' => 'English language and literature questions',
                'questions' => [
                    [
                        'question' => 'Which word is a synonym for "happy"?',
                        'difficulty' => DifficultyLevel::Easy,
                        'explanation' => 'Joyful and happy have similar meanings.',
                        'answers' => [
                            ['answer' => 'Joyful', 'correct' => true],
                            ['answer' => 'Sad', 'correct' => false],
                            ['answer' => 'Angry', 'correct' => false],
                            ['answer' => 'Tired', 'correct' => false],
                        ],
                    ],
                    [
                        'question' => 'Choose the correct past tense: "Yesterday, I ___ to the store."',
                        'difficulty' => DifficultyLevel::Easy,
                        'explanation' => 'Go in past tense is "went".',
                        'answers' => [
                            ['answer' => 'went', 'correct' => true],
                            ['answer' => 'goed', 'correct' => false],
                            ['answer' => 'gone', 'correct' => false],
                            ['answer' => 'going', 'correct' => false],
                        ],
                    ],
                    [
                        'question' => 'Which sentence contains a metaphor?',
                        'difficulty' => DifficultyLevel::Medium,
                        'explanation' => 'A metaphor directly compares two things without "like" or "as".',
                        'answers' => [
                            ['answer' => 'The world is a stage.', 'correct' => true],
                            ['answer' => 'She runs like a cheetah.', 'correct' => false],
                            ['answer' => 'He is as brave as a lion.', 'correct' => false],
                            ['answer' => 'The clouds are floating.', 'correct' => false],
                        ],
                    ],
                    [
                        'question' => 'What is the plural of "child"?',
                        'difficulty' => DifficultyLevel::Easy,
                        'explanation' => 'Child is an irregular noun with plural "children".',
                        'answers' => [
                            ['answer' => 'Children', 'correct' => true],
                            ['answer' => 'Childs', 'correct' => false],
                            ['answer' => 'Childes', 'correct' => false],
                            ['answer' => 'Childrens', 'correct' => false],
                        ],
                    ],
                    [
                        'question' => 'Which word is an antonym of "ancient"?',
                        'difficulty' => DifficultyLevel::Easy,
                        'explanation' => 'Modern is the opposite of ancient.',
                        'answers' => [
                            ['answer' => 'Modern', 'correct' => true],
                            ['answer' => 'Old', 'correct' => false],
                            ['answer' => 'Historic', 'correct' => false],
                            ['answer' => 'Aged', 'correct' => false],
                        ],
                    ],
                    [
                        'question' => 'Identify the subject in: "The quick brown fox jumps over the lazy dog."',
                        'difficulty' => DifficultyLevel::Medium,
                        'explanation' => 'The subject is what the sentence is about - the fox performs the action.',
                        'answers' => [
                            ['answer' => 'The quick brown fox', 'correct' => true],
                            ['answer' => 'jumps', 'correct' => false],
                            ['answer' => 'the lazy dog', 'correct' => false],
                            ['answer' => 'over', 'correct' => false],
                        ],
                    ],
                    [
                        'question' => 'Which article should be used before "honest"?',
                        'difficulty' => DifficultyLevel::Easy,
                        'explanation' => 'Use "an" before words that start with a vowel sound. "Honest" starts with a vowel sound.',
                        'answers' => [
                            ['answer' => 'An', 'correct' => true],
                            ['answer' => 'A', 'correct' => false],
                            ['answer' => 'The', 'correct' => false],
                            ['answer' => 'No article', 'correct' => false],
                        ],
                    ],
                    [
                        'question' => 'What type of noun is "happiness"?',
                        'difficulty' => DifficultyLevel::Medium,
                        'explanation' => 'Happiness is an abstract noun - it cannot be touched or seen.',
                        'answers' => [
                            ['answer' => 'Abstract noun', 'correct' => true],
                            ['answer' => 'Proper noun', 'correct' => false],
                            ['answer' => 'Collective noun', 'correct' => false],
                            ['answer' => 'Countable noun', 'correct' => false],
                        ],
                    ],
                    [
                        'question' => 'Complete: "Neither the teacher ___ the students knew the answer."',
                        'difficulty' => DifficultyLevel::Medium,
                        'explanation' => 'After "neither" we use "nor".',
                        'answers' => [
                            ['answer' => 'nor', 'correct' => true],
                            ['answer' => 'or', 'correct' => false],
                            ['answer' => 'and', 'correct' => false],
                            ['answer' => 'but', 'correct' => false],
                        ],
                    ],
                    [
                        'question' => 'Which sentence uses the semicolon correctly?',
                        'difficulty' => DifficultyLevel::Hard,
                        'explanation' => 'Semicolons connect two independent clauses.',
                        'answers' => [
                            ['answer' => 'I love reading; my sister prefers watching TV.', 'correct' => true],
                            ['answer' => 'I love reading; reading is fun.', 'correct' => false],
                            ['answer' => 'I love reading; because it is fun.', 'correct' => false],
                            ['answer' => 'I love reading; my sister.', 'correct' => false],
                        ],
                    ],
                ],
            ],
            'Science' => [
                'description' => 'Physics, Chemistry, and Biology questions',
                'questions' => [
                    [
                        'question' => 'Jakie jest pH wody czystej?',
                        'difficulty' => DifficultyLevel::Easy,
                        'explanation' => 'Woda czysta ma pH równe 7, co oznacza obojętność.',
                        'answers' => [
                            ['answer' => '7', 'correct' => true],
                            ['answer' => '1', 'correct' => false],
                            ['answer' => '14', 'correct' => false],
                            ['answer' => '0', 'correct' => false],
                        ],
                    ],
                    [
                        'question' => 'Ile wynosi prędkość światła w próżni?',
                        'difficulty' => DifficultyLevel::Medium,
                        'explanation' => 'Prędkość światła wynosi około 300 000 km/s.',
                        'answers' => [
                            ['answer' => '≈ 300 000 km/s', 'correct' => true],
                            ['answer' => '≈ 150 000 km/s', 'correct' => false],
                            ['answer' => '≈ 1 000 000 km/s', 'correct' => false],
                            ['answer' => '≈ 100 000 km/s', 'correct' => false],
                        ],
                    ],
                    [
                        'question' => 'Który pierwiastek ma symbol Au?',
                        'difficulty' => DifficultyLevel::Easy,
                        'explanation' => 'Au to symbol złota (Aurum po łacinie).',
                        'answers' => [
                            ['answer' => 'Złoto', 'correct' => true],
                            ['answer' => 'Srebro', 'correct' => false],
                            ['answer' => 'Miedź', 'correct' => false],
                            ['answer' => 'Aluminium', 'correct' => false],
                        ],
                    ],
                    [
                        'question' => 'Co jest głównym źródłem energii dla organizmów?',
                        'difficulty' => DifficultyLevel::Easy,
                        'explanation' => 'Glukoza jest głównym źródłem energii dla komórek.',
                        'answers' => [
                            ['answer' => 'Glukoza', 'correct' => true],
                            ['answer' => 'Tłuszcze', 'correct' => false],
                            ['answer' => 'Białka', 'correct' => false],
                            ['answer' => 'Witaminy', 'correct' => false],
                        ],
                    ],
                    [
                        'question' => 'Ile wynosi temperatura wrzenia wody?',
                        'difficulty' => DifficultyLevel::Easy,
                        'explanation' => 'Woda wrze w temperaturze 100°C przy ciśnieniu atmosferycznym.',
                        'answers' => [
                            ['answer' => '100°C', 'correct' => true],
                            ['answer' => '0°C', 'correct' => false],
                            ['answer' => '50°C', 'correct' => false],
                            ['answer' => '212°C', 'correct' => false],
                        ],
                    ],
                    [
                        'question' => 'Który narząd produkuje insulinę?',
                        'difficulty' => DifficultyLevel::Medium,
                        'explanation' => 'Trzustka produkuje insulinę, która reguluje poziom cukru we krwi.',
                        'answers' => [
                            ['answer' => 'Trzustka', 'correct' => true],
                            ['answer' => 'Wątroba', 'correct' => false],
                            ['answer' => 'Nerki', 'correct' => false],
                            ['answer' => 'Serce', 'correct' => false],
                        ],
                    ],
                    [
                        'question' => 'Co mierzy się w watach?',
                        'difficulty' => DifficultyLevel::Easy,
                        'explanation' => 'Wat (W) jest jednostką mocy w układzie SI.',
                        'answers' => [
                            ['answer' => 'Moc', 'correct' => true],
                            ['answer' => 'Energia', 'correct' => false],
                            ['answer' => 'Napięcie', 'correct' => false],
                            ['answer' => 'Prąd', 'correct' => false],
                        ],
                    ],
                    [
                        'question' => 'Ile chromosomów ma komórka ludzka?',
                        'difficulty' => DifficultyLevel::Medium,
                        'explanation' => 'Komórka somatyczna człowieka ma 46 chromosomów (23 pary).',
                        'answers' => [
                            ['answer' => '46', 'correct' => true],
                            ['answer' => '23', 'correct' => false],
                            ['answer' => '42', 'correct' => false],
                            ['answer' => '48', 'correct' => false],
                        ],
                    ],
                    [
                        'question' => 'Jak nazywa się H2O w stanie stałym?',
                        'difficulty' => DifficultyLevel::Easy,
                        'explanation' => 'Lód to woda w stanie stałym.',
                        'answers' => [
                            ['answer' => 'Lód', 'correct' => true],
                            ['answer' => 'Para', 'correct' => false],
                            ['answer' => 'Rosa', 'correct' => false],
                            ['answer' => 'Mgła', 'correct' => false],
                        ],
                    ],
                    [
                        'question' => 'Który gaz stanowi największy procent powietrza?',
                        'difficulty' => DifficultyLevel::Easy,
                        'explanation' => 'Azot (N2) stanowi około 78% atmosfery ziemskiej.',
                        'answers' => [
                            ['answer' => 'Azot', 'correct' => true],
                            ['answer' => 'Tlen', 'correct' => false],
                            ['answer' => 'Dwutlenek węgla', 'correct' => false],
                            ['answer' => 'Wodór', 'correct' => false],
                        ],
                    ],
                ],
            ],
            'History' => [
                'description' => 'World and local history questions',
                'questions' => [
                    [
                        'question' => 'W którym roku człowiek wylądował na Księżycu?',
                        'difficulty' => DifficultyLevel::Medium,
                        'explanation' => 'Apollo 11 wylądował na Księżycu 20 lipca 1969 roku.',
                        'answers' => [
                            ['answer' => '1969', 'correct' => true],
                            ['answer' => '1959', 'correct' => false],
                            ['answer' => '1979', 'correct' => false],
                            ['answer' => '1989', 'correct' => false],
                        ],
                    ],
                    [
                        'question' => 'Kto był pierwszym królem Polski?',
                        'difficulty' => DifficultyLevel::Easy,
                        'explanation' => 'Mieszko I był pierwszym władcą Polski, który przyjął chrześcijaństwo.',
                        'answers' => [
                            ['answer' => 'Mieszko I', 'correct' => true],
                            ['answer' => 'Bolesław Chrobry', 'correct' => false],
                            ['answer' => 'Kazimierz Wielki', 'correct' => false],
                            ['answer' => 'Władysław Jagiełło', 'correct' => false],
                        ],
                    ],
                    [
                        'question' => 'Kiedy wybuchła II wojna światowa?',
                        'difficulty' => DifficultyLevel::Easy,
                        'explanation' => 'II wojna światowa rozpoczęła się 1 września 1939 roku.',
                        'answers' => [
                            ['answer' => '1939', 'correct' => true],
                            ['answer' => '1940', 'correct' => false],
                            ['answer' => '1938', 'correct' => false],
                            ['answer' => '1941', 'correct' => false],
                        ],
                    ],
                    [
                        'question' => 'Kto malował "Gwiaździstą noc"?',
                        'difficulty' => DifficultyLevel::Medium,
                        'explanation' => 'Vincent van Gogh namalował "Gwiaździstą noc" w 1889 roku.',
                        'answers' => [
                            ['answer' => 'Vincent van Gogh', 'correct' => true],
                            ['answer' => 'Pablo Picasso', 'correct' => false],
                            ['answer' => 'Claude Monet', 'correct' => false],
                            ['answer' => 'Leonardo da Vinci', 'correct' => false],
                        ],
                    ],
                    [
                        'question' => 'Co to jest Renesans?',
                        'difficulty' => DifficultyLevel::Medium,
                        'explanation' => 'Renesans to okres odrodzenia kultury i nauki w XIV-XVI wieku.',
                        'answers' => [
                            ['answer' => 'Okres odrodzenia kultury i nauki', 'correct' => true],
                            ['answer' => 'Epoka lodowcowa', 'correct' => false],
                            ['answer' => 'Wojna religijna', 'correct' => false],
                            ['answer' => 'Rewolucja przemysłowa', 'correct' => false],
                        ],
                    ],
                    [
                        'question' => 'Kto zbudował piramidy w Gizie?',
                        'difficulty' => DifficultyLevel::Easy,
                        'explanation' => 'Piramidy w Gizie zostały zbudowane przez starożytnych Egipcjan.',
                        'answers' => [
                            ['answer' => 'Starożytni Egipcjanie', 'correct' => true],
                            ['answer' => 'Starożytni Grecy', 'correct' => false],
                            ['answer' => 'Starożytni Rzymianie', 'correct' => false],
                            ['answer' => 'Majowie', 'correct' => false],
                        ],
                    ],
                    [
                        'question' => 'W którym roku powstała ONZ?',
                        'difficulty' => DifficultyLevel::Medium,
                        'explanation' => 'ONZ (Organizacja Narodów Zjednoczonych) została założona w 1945 roku.',
                        'answers' => [
                            ['answer' => '1945', 'correct' => true],
                            ['answer' => '1944', 'correct' => false],
                            ['answer' => '1946', 'correct' => false],
                            ['answer' => '1943', 'correct' => false],
                        ],
                    ],
                    [
                        'question' => 'Kim był Napoleon Bonaparte?',
                        'difficulty' => DifficultyLevel::Easy,
                        'explanation' => 'Napoleon Bonaparte był francuskim cesarzem i wybitnym dowódcą wojskowym.',
                        'answers' => [
                            ['answer' => 'Francuskim cesarzem', 'correct' => true],
                            ['answer' => 'Brytyjskim królem', 'correct' => false],
                            ['answer' => 'Niemieckim kanclerzem', 'correct' => false],
                            ['answer' => 'Włoskim politykiem', 'correct' => false],
                        ],
                    ],
                ],
            ],
            'Programming' => [
                'description' => 'Computer programming and algorithms',
                'questions' => [
                    [
                        'question' => 'What does HTML stand for?',
                        'difficulty' => DifficultyLevel::Easy,
                        'explanation' => 'HTML stands for HyperText Markup Language.',
                        'answers' => [
                            ['answer' => 'HyperText Markup Language', 'correct' => true],
                            ['answer' => 'High Tech Modern Language', 'correct' => false],
                            ['answer' => 'Home Tool Markup Language', 'correct' => false],
                            ['answer' => 'Hyperlinks and Text Markup Language', 'correct' => false],
                        ],
                    ],
                    [
                        'question' => 'Which programming language is known as the "language of the web"?',
                        'difficulty' => DifficultyLevel::Easy,
                        'explanation' => 'JavaScript is the primary language for web development.',
                        'answers' => [
                            ['answer' => 'JavaScript', 'correct' => true],
                            ['answer' => 'Python', 'correct' => false],
                            ['answer' => 'Java', 'correct' => false],
                            ['answer' => 'C++', 'correct' => false],
                        ],
                    ],
                    [
                        'question' => 'What is the time complexity of binary search?',
                        'difficulty' => DifficultyLevel::Medium,
                        'explanation' => 'Binary search divides the search space in half each time, giving O(log n).',
                        'answers' => [
                            ['answer' => 'O(log n)', 'correct' => true],
                            ['answer' => 'O(n)', 'correct' => false],
                            ['answer' => 'O(n²)', 'correct' => false],
                            ['answer' => 'O(1)', 'correct' => false],
                        ],
                    ],
                    [
                        'question' => 'Which data structure uses LIFO (Last In, First Out)?',
                        'difficulty' => DifficultyLevel::Easy,
                        'explanation' => 'Stack follows the LIFO principle - last element added is first to be removed.',
                        'answers' => [
                            ['answer' => 'Stack', 'correct' => true],
                            ['answer' => 'Queue', 'correct' => false],
                            ['answer' => 'Array', 'correct' => false],
                            ['answer' => 'Linked List', 'correct' => false],
                        ],
                    ],
                    [
                        'question' => 'What is Git used for?',
                        'difficulty' => DifficultyLevel::Easy,
                        'explanation' => 'Git is a version control system for tracking changes in code.',
                        'answers' => [
                            ['answer' => 'Version control', 'correct' => true],
                            ['answer' => 'Database management', 'correct' => false],
                            ['answer' => 'Web hosting', 'correct' => false],
                            ['answer' => 'Code compilation', 'correct' => false],
                        ],
                    ],
                    [
                        'question' => 'What does SQL stand for?',
                        'difficulty' => DifficultyLevel::Easy,
                        'explanation' => 'SQL stands for Structured Query Language.',
                        'answers' => [
                            ['answer' => 'Structured Query Language', 'correct' => true],
                            ['answer' => 'Simple Query Language', 'correct' => false],
                            ['answer' => 'Standard Query Language', 'correct' => false],
                            ['answer' => 'System Query Language', 'correct' => false],
                        ],
                    ],
                    [
                        'question' => 'What is the output of: print(type([])) in Python?',
                        'difficulty' => DifficultyLevel::Medium,
                        'explanation' => 'In Python, [] creates a list, and type() returns the class name.',
                        'answers' => [
                            ['answer' => "<class 'list'>", 'correct' => true],
                            ['answer' => "<class 'array'>", 'correct' => false],
                            ['answer' => "<class 'tuple'>", 'correct' => false],
                            ['answer' => "<class 'dict'>", 'correct' => false],
                        ],
                    ],
                    [
                        'question' => 'Which sorting algorithm has the best average time complexity?',
                        'difficulty' => DifficultyLevel::Hard,
                        'explanation' => 'Merge sort has O(n log n) average and worst case complexity.',
                        'answers' => [
                            ['answer' => 'Merge Sort (O(n log n))', 'correct' => true],
                            ['answer' => 'Bubble Sort (O(n²))', 'correct' => false],
                            ['answer' => 'Quick Sort (O(n²) worst)', 'correct' => false],
                            ['answer' => 'Selection Sort (O(n²))', 'correct' => false],
                        ],
                    ],
                    [
                        'question' => 'What is Docker used for?',
                        'difficulty' => DifficultyLevel::Medium,
                        'explanation' => 'Docker is a platform for containerizing applications.',
                        'answers' => [
                            ['answer' => 'Containerization', 'correct' => true],
                            ['answer' => 'Version control', 'correct' => false],
                            ['answer' => 'Code editing', 'correct' => false],
                            ['answer' => 'Testing frameworks', 'correct' => false],
                        ],
                    ],
                    [
                        'question' => 'What is an API?',
                        'difficulty' => DifficultyLevel::Easy,
                        'explanation' => 'API (Application Programming Interface) allows communication between software components.',
                        'answers' => [
                            ['answer' => 'Application Programming Interface', 'correct' => true],
                            ['answer' => 'Application Process Integration', 'correct' => false],
                            ['answer' => 'Automated Programming Interface', 'correct' => false],
                            ['answer' => 'Application Protocol Integration', 'correct' => false],
                        ],
                    ],
                ],
            ],
        ];

        foreach ($categories as $categoryName => $categoryData) {
            $category = QuestionCategory::firstOrCreate(
                ['name' => $categoryName],
                ['description' => $categoryData['description']]
            );

            foreach ($categoryData['questions'] as $questionData) {
                $answers = $questionData['answers'];
                unset($questionData['answers']);

                $question = Question::create([
                    'question' => $questionData['question'],
                    'question_category_id' => $category->id,
                    'difficulty' => $questionData['difficulty'],
                    'explanation' => $questionData['explanation'] ?? null,
                    'created_by' => $admin->id,
                ]);

                foreach ($answers as $answer) {
                    QuestionAnswer::create([
                        'question_id' => $question->id,
                        'answer' => $answer['answer'],
                        'is_correct' => $answer['correct'],
                    ]);
                }
            }
        }

        ExamTest::truncate();
        ExamTest::create([
            'title' => 'Matematyka - Test Podstawowy',
            'description' => 'Test sprawdzający podstawową wiedzę matematyczną',
            'number_of_questions' => 5,
            'generation_type' => 'manual',
            'created_by' => $admin->id,
            'generated_at' => now(),
        ])->questions()->attach(
            Question::whereHas('category', fn ($q) => $q->where('name', 'Mathematics'))->inRandomOrder()->limit(5)->pluck('id')
        );

        ExamTest::create([
            'title' => 'English Language Test',
            'description' => 'Test of English grammar and vocabulary',
            'number_of_questions' => 5,
            'generation_type' => 'manual',
            'created_by' => $admin->id,
            'generated_at' => now(),
        ])->questions()->attach(
            Question::whereHas('category', fn ($q) => $q->where('name', 'English'))->inRandomOrder()->limit(5)->pluck('id')
        );

        ExamTest::create([
            'title' => 'Mixed Science Quiz',
            'description' => 'Mixed questions from physics, chemistry, and biology',
            'number_of_questions' => 5,
            'generation_type' => 'manual',
            'created_by' => $admin->id,
            'generated_at' => now(),
        ])->questions()->attach(
            Question::whereHas('category', fn ($q) => $q->where('name', 'Science'))->inRandomOrder()->limit(5)->pluck('id')
        );
    }
}
