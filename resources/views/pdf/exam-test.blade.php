<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $examTest->title }}</title>
    <style>
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            color: #1f2937;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .question-block {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }
        .question-number {
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 5px;
        }
        .question-text {
            margin-bottom: 10px;
            padding: 10px;
            background-color: #f3f4f6;
            border-left: 3px solid #3b82f6;
        }
        .answer-option {
            margin-left: 20px;
            margin-bottom: 8px;
            padding: 8px;
        }
        .answer-letter {
            font-weight: bold;
            width: 20px;
            display: inline-block;
        }
        .correct-answer {
            background-color: #d1fae5;
            border-left: 3px solid #10b981;
            padding: 8px;
            margin-left: 20px;
            margin-bottom: 8px;
            color: #065f46;
        }
        .explanation {
            background-color: #fef3c7;
            border-left: 3px solid #f59e0b;
            padding: 10px;
            margin-left: 20px;
            margin-top: 10px;
            font-size: 0.9em;
            color: #78350f;
        }
        .category-badge {
            display: inline-block;
            background-color: #dbeafe;
            color: #1e40af;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 0.85em;
            margin-right: 10px;
        }
        .difficulty-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 0.85em;
            font-weight: bold;
        }
        .difficulty-easy {
            background-color: #d1fae5;
            color: #065f46;
        }
        .difficulty-medium {
            background-color: #fef3c7;
            color: #78350f;
        }
        .difficulty-hard {
            background-color: #fee2e2;
            color: #7f1d1d;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            color: #999;
            font-size: 0.9em;
        }
        .answer-key-header {
            background-color: #10b981;
            color: white;
            padding: 10px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $examTest->title }}</h1>
        @if($examTest->description)
            <p>{{ $examTest->description }}</p>
        @endif
        <p><strong>Number of Questions:</strong> {{ $questions->count() }}</p>
        <p><strong>Generated:</strong> {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    @if($includeAnswers)
        <div class="answer-key-header">
            ANSWER KEY & DETAILED SOLUTIONS
        </div>
    @endif

    @foreach($questions as $index => $question)
        <div class="question-block">
            <div class="question-number">
                Question {{ $index + 1 }}
                <span class="category-badge">{{ $question->category->name }}</span>
                <span class="difficulty-badge difficulty-{{ $question->difficulty->value }}">
                    {{ ucfirst($question->difficulty->value) }}
                </span>
            </div>
            
            <div class="question-text">
                {{ $question->question }}
            </div>

            <div>
                @php
                    $answers = $question->answers()->inRandomOrder()->get();
                    $correctAnswer = $question->answers()->where('is_correct', true)->first();
                @endphp

                @foreach($answers as $answerIndex => $answer)
                    <div class="answer-option">
                        <span class="answer-letter">{{ chr(65 + $answerIndex) }}.</span>
                        {{ $answer->answer }}
                        @if($includeAnswers && $answer->is_correct)
                            <strong style="color: #10b981;"> ✓ CORRECT</strong>
                        @endif
                    </div>
                @endforeach
            </div>

            @if($includeAnswers && $question->explanation)
                <div class="explanation">
                    <strong>Explanation:</strong> {{ $question->explanation }}
                </div>
            @endif
        </div>
    @endforeach

    <div class="footer">
        <p>This exam was generated from the Question Bank System</p>
        <p>{{ config('app.name') }} © {{ now()->year }}</p>
    </div>
</body>
</html>
