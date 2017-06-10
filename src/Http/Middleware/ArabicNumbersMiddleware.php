<?php

namespace AbdullahObaid\ArabicNumbers\Http\Middleware;

use Closure;

class ArabicNumbersMiddleware
{
    /**
     * @var array
     */
    protected $except = ['password', 'password_confirmation'];

    /**
     * @param \Illuminate\Http\Request $request
     * @param Closure $next
     */
    public function handle($request, Closure $next)
    {
        $except = array_merge($this->except, array_slice(func_get_args(), 2));
        $request->merge($this->process($request->except($except)));
        return $next($request);
    }

    /**
     * @param array $data
     *
     * @return array
     */
    protected function process(array $data)
    {
        array_walk_recursive($data, function (&$value, $key) {
            $value = $this->processValue($value, $key);
        });
        return $data;
    }

    /**
     * @param mixed $value
     * @param string $key
     *
     * @return mixed
     */
    protected function processValue($value, $key)
    {
        if (is_string($value)) {
            $arabic_eastern = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');
            $arabic_western = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
            return str_replace($arabic_eastern, $arabic_western, $value);
        }
        return $value;
    }
}
