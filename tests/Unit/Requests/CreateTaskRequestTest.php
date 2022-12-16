<?php

namespace Tests\Unit\Requests;

use App\Http\Requests\Task\CreateTaskRequest;
use App\Models\Task;
use Carbon\CarbonImmutable;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class CreateTaskRequestTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    private function defaultData(): array
    {
        return [
            'user_id' => 1,
            'title' => 'title',
            'type' => Task::TASK,
            'status' => Task::UNSUPPORTED,
            'description' => '',
            'start_date' => CarbonImmutable::now()->toDateString(),
            'end_date' => CarbonImmutable::now()->addDays(3)->toDateString(),
            'file' => UploadedFile::fake()->image('image.png'),
        ];
    }

    /**
     * バリデーションチェック
     *
     * @param  string $key
     * @param  mixed $data
     * @param  bool $expected
     * @dataProvider requestDataProvider
     */
    public function testValidate($key, $data, $expected)
    {
        $request = new CreateTaskRequest();
        $dataList = $this->defaultData();
        $dataList[$key] = $data;

        $validator = Validator::make($dataList, $request->rules());
        $result = $validator->passes();
        $this->assertEquals($expected, $result);
    }

    public function requestDataProvider(): array
    {
        return [
            // ユーザID
            'ユーザID 正常' => ['user_id', 1, true],
            'ユーザID 正常 NULL' => ['user_id', null, true],
            'ユーザID 異常 マルチバイト' => ['user_id', '１', false],
            // タイトル
            'タイトル 正常' => ['title', 'title', true],
            'タイトル 異常 NULL' => ['title', null, false],
            'タイトル 異常 空文字' => ['title', '', false],
            // 種別
            '種別 正常' => ['type', Task::TASK, true],
            '種別 異常 NULL' => ['type', null, false],
            // 状態
            '状態 正常' => ['status', Task::UNSUPPORTED, true],
            '状態 異常 NULL' => ['status', null, false],
            // 開始日
            '開始日 正常' => ['start_date', '2022-12-11 12:00:00', true],
            '開始日 異常 時刻ではない' => ['start_date', '2022年12月11日', false],
            // 期限日
            '期限日 正常' => ['end_date', '2022-12-11 12:00:00', true],
            '期限日 異常 時刻ではない' => ['end_date', '2022年12月11日', false],
            // ファイル
            'ファイル 正常 jpg' => ['file', UploadedFile::fake()->image('image.jpg'), true],
            'ファイル 正常 jpeg' => ['file', UploadedFile::fake()->image('image.jpeg'), true],
            'ファイル 正常 png' => ['file', UploadedFile::fake()->image('image.png'), true],
            'ファイル 正常 ファイルサイズが10MB' => ['file', UploadedFile::fake()->create('image.png', 10240), true],
            'ファイル 異常 ファイル形式がgif' => ['file', UploadedFile::fake()->image('image.gif'), false],
            'ファイル 異常 ファイル形式がsvg' => ['file', UploadedFile::fake()->image('image.svg'), false],
            'ファイル 異常 画像ではない(pdf)' => ['file', UploadedFile::fake()->create('document.pdf'), false],
            'ファイル 異常 ファイルサイズが10MB超過' => ['file', UploadedFile::fake()->create('image.png', 10241), false],
        ];
    }
}
