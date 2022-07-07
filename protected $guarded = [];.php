    protected $guarded = [];

    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot() {

        parent::boot();

        static::creating(function ($model) {
            if ($model->getKey() == null) {
                $model->setAttribute($model->getKeyName(), Str::uuid()->toString());
            }
        });
    }

            'product_name' => $this->faker->name(),
            'product_price'=> $this->faker->numberBetween($min = 1500, $max = 2000),
            'product_quantity' => $this->faker->numberBetween($min = 1, $max = 10)

            $table->bigIncrements('id');
            $table->string('id')->primary();
            $table->string('product_name');
            $table->integer('product_price');
            $table->integer('product_quantity');
            $table->timestamps();

            $table->index(['id']);

            \App\Models\Product::factory(20)->create();

Route::get('v1/products', [ProductController::class, 'readAllProduct']);
Route::get('v1/products/{pageSize}/{pageIndex}', [ProductController::class, '']);
Route::get('v1/products/{sortBy}/{sorting}/{filterByColumn}/{searchByColumn}', [ProductController::class, '']);

Route::post('v1/products', [ProductController::class, 'insertProduct']);
Route::put('v1/products', [ProductController::class, 'updateProduct']);
Route::delete('v1/products/{id}', [ProductController::class, 'deleteProduct']);

Route::post('v1/transaction', [TransactionController::class, 'transaction']);
Route::put('v1/transaction', [TransactionController::class, 'transaction']);

seed factory