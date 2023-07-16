<?php

namespace App\Http\Requests;

use App\Repository\FileTypeRepository;
use App\Rules\BookFileExtension;
use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{
  private $fileTypeRepository;

  public function __construct(FileTypeRepository $fileTypeRepository) {
    $this->fileTypeRepository = $fileTypeRepository;
  }
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    return $this->user()->can('is-admin');
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
   */
  public function rules(): array
  {
    $fileTypeRules = [];
    
    foreach ($this->fileTypeRepository->getAll() as $fileType) {
      $fileTypeRules[$fileType->name] = [new BookFileExtension];
    }


    return [
      'title' => 'required',
      // 'numPages' => 'required|gt:0',
      'cover' => 'required|image',
      ...$fileTypeRules
    ];
  }

  public function messages(): array {

    return [
      'title.required' => 'Vui lòng nhập tên sách',

      // 'numPages.required' => 'Vui lòng nhập số trang',
      // 'numPages.gt' => 'Số trang phải lớn hơn 0',

      'cover.required' => 'Vui lòng tải ảnh bìa',
      'cover.image' => 'Vui lòng chọn file có định dạng png/jpg'
    ];
  }
}
