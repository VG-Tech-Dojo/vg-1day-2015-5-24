## <a name="error"></a> エラーレスポンスについて

### エラーレスポンスの構造

エラーレスポンスは 4xx 台もしくは 5xx 台の HTTP ステータスコードとともに、以下の形式の (JSON シリアライズされた) レスポンスボディを伴う形で返されます。

これは単一または複数のエラー内容を説明する JSON オブジェクトを有する JSON 配列となります。

```
HTTP/1.1 500 Internal Server Error
Content-Type: application/json

[
    {
        "code": "a_machine_readable_error_description",
        "message": "人間にとって可読なエラーの説明文が入ります。"
    },
    {
        "code": "a_machine_readable_error_description_2",
        "message": "人間にとって可読なエラーの説明文のふたつ目が入ります。"
    }
]
```

`code` はエラーの内容をプログラムから機械的に識別するために用意された値で、 `code` が取りうる値はすべて以下に示されます。

`message` は人間が読むことを想定した、自然言語によって記述されたエラーに関する説明文となります。

### エラーコードの値

エラーレスポンスにて用いられるエラーコードと対応する HTTP ステータスコードを下表に示します。

エラーコード | HTTP ステータスコード | 説明
--- | --- | ---
`invalid-json` | 400 | リクエストボディにて指定された JSON のパースに失敗した
`validation-error` | 400 | 入力値の検証に失敗した
`not-found` | 404 | リクエストされたリソースや API が存在しない
`unexpected` | 500 | サーバ側でハンドリングできなかった予期せぬエラー
