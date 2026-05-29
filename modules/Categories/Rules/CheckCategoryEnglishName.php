<?php

namespace Modules\Categories\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Modules\Categories\Models\Category;

class CheckCategoryEnglishName implements ValidationRule
{
    protected int $categoryId;
    public function __construct( $id){
        $this->categoryId = intval($id);
    }
    /**
     * Run the validation rule.
     *
//     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
       $category = Category::where('ename', $value)
           ->where('id', '!=', $this->categoryId)
           ->first();
       if($category){
           $fail('نام انتخاب شده برای این دسته تکراری است');
       }
    }
}
