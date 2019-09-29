<?php

namespace app\common\classes;

/**
 * Class HttpClient
 * 提供get,post,delete,put等http请求方式
 * 可传输文件
 * 可获取response头信息（默认不获取）
 * 可设置不获取response正文（默认获取）
 * response可将body转为对象或数组
 * 可单独设置query|body参数，满足特殊需求
 */
class HttpClient
{

    private $ch;
    private $baseUrl = '';
    private $onlyHeader = false;
    private $fullResponse = false;
    private $options = [];
    private $headerParams = [];
    private $queryParams = [];
    private $bodyParams = [];

    //初始化
    public function __construct($baseUrl = null)
    {
        $this->ch = curl_init();
        //不自动输出
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true); //设置获取的信息以文件流的形式返回，而不是直接输出
        curl_setopt($this->ch, CURLOPT_ENCODING, 'UTF-8');
        curl_setopt($this->ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        if ($baseUrl) {
            $this->setBaseUrl($baseUrl);
        }
        $this->setTimeout(30);
        $this->followLocation(true);
    }

    //设置基础url
    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;
        return $this;
    }

    //设置是否返回头信息
    public function fullResponse($full = true)
    {
        $this->fullResponse = $full;
        return $this;
    }

    //是否返回只返回头部
    public function onlyHeader($only = true)
    {
        $this->onlyHeader = $only;
        return $this;
    }

    //是否跟随跳转
    public function followLocation($follow = false)
    {
        return $this->setOption(CURLOPT_FOLLOWLOCATION, $follow);  //根据服务器返回 HTTP 头中的'Location:'重定向
    }

    //处理拼接基础url
    private function resolveUrl($url)
    {
        if (empty($this->baseUrl)) {
            return $url;
        }
        return rtrim($this->baseUrl, '/ ') . '/' . ltrim($url, '/ ');
    }

    //设置curl属性
    public function setOption($option, $value)
    {
        $this->options[$option] = $value;
        return $this;
    }

    //批量设置curl属性
    public function setOptions($options)
    {
        $this->options = $options + $this->options;
        return $this;
    }

    //设置超时时间
    public function setTimeout($timeOut = 10)
    {
        if ($timeOut == 0) {
            unset($this->options[CURLOPT_TIMEOUT], $this->options[CURLOPT_TIMEOUT_MS]);
        } elseif ($timeOut < 1) {
            $timeOut = $timeOut * 1000;
            $this->setOption(CURLOPT_TIMEOUT_MS, $timeOut);
        } else {
            $this->setOption(CURLOPT_TIMEOUT, $timeOut);
        }
        return $this;
    }

    //设置连接超时时间
    public function setConnectTimeout($timeout = 2)
    {
        return $this->setOption(CURLOPT_CONNECTTIMEOUT, $timeout);
    }

    //不返回Header
    public function disableHeader($disable = true)
    {
        return $this->setOption(CURLOPT_HEADER, $disable);
    }

    //不返回Body
    public function disableBody($disable = true)
    {
        return $this->setOption(CURLOPT_NOBODY, $disable);
    }

    //设置userAgent
    public function setUserAgent($userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36')
    {
        return $this->setOption(CURLOPT_USERAGENT, $userAgent);
    }

    //设置http头属性
    public function setHeader($option, $value)
    {
        $this->headerParams[$option] = $value;
        return $this;
    }

    //批量设置http头属性
    public function setHeaders(array $options)
    {
        $this->headerParams = array_merge($this->headerParams, $options);
        return $this;
    }

    //删除http头属性
    public function removeHeader($name)
    {
        unset($this->headerParams[$name]);
        return $this;
    }

    //设置query参数
    public function setQueryParams($params)
    {
        $this->queryParams = $params;
        return $this;
    }

    //设置body参数
    public function setBodyParams($params, $doJson = false)
    {
        if ($doJson) {
            $this->setHeader('Content-Type', 'application/json');
            $params = json_encode($params, JSON_UNESCAPED_UNICODE);
        }
        $this->bodyParams = $params;
        return $this;
    }

    //处理并设置http头
    private function resolveHeader()
    {
        if (!empty($this->headerParams)) {
            $headerLine = [];
            foreach ($this->headerParams as $field => $value) {
                $headerLine[] = $field . ': ' . $value;
            }
            $this->setOption(CURLOPT_HTTPHEADER, $headerLine);
        }
    }

    //处理正文
    private function resolveBody($useEncoding = true)
    {
        if (is_array($this->bodyParams)) {
            //有文件则不使用urlencode
            foreach ($this->bodyParams as $param) {
                if ((is_string($param) && strpos($param, '@') === 0) || ($param instanceof \CURLFile)) {
                    $useEncoding = false;
                    break;
                }
            }
            if ($useEncoding) {
                $this->bodyParams = http_build_query($this->bodyParams);
            }
        }
        if ($this->bodyParams) {
            $this->setOption(CURLOPT_POSTFIELDS, $this->bodyParams);
        }
    }

    /**
     * GET方式请求
     *
     * @param $path
     * @param array $params
     * @return HttpResponse
     */
    public function get($path, $params = [])
    {
        $this->setQueryParams($params);
        $this->setOptions([
            CURLOPT_HTTPGET => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ]);

        return $this->send($path);
    }

    /**
     * POST方式请求
     *
     * @param $path
     * @param array $params
     * @param bool $useEncoding
     * @return HttpResponse
     */
    public function post($path, $params = [], $useEncoding = true)
    {
        $this->setBodyParams($params);
        $this->setOptions([
            CURLOPT_POST => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
        ]);

        return $this->send($path, $useEncoding);
    }

    /**
     * POST方式提交json数据
     *
     * @param $path
     * @param array $params
     * @param bool $useEncoding
     * @return HttpResponse
     */
    public function postJson($path, $params = [], $useEncoding = true)
    {
        $this->setHeader('Content-Type', 'application/json');
        return $this->post($path, json_encode($params, JSON_UNESCAPED_UNICODE), $useEncoding);
    }

    /**
     * DELETE方式请求
     *
     * @param $path
     * @param array $params
     * @return HttpResponse
     */
    public function delete($path, $params = [])
    {
        $this->setQueryParams($params);
        $this->setOptions([
            CURLOPT_HTTPGET => true,
            CURLOPT_CUSTOMREQUEST => 'DELETE',
        ]);

        return $this->send($path);
    }

    /**
     * PUT方式请求
     *
     * @param $path
     * @param array $params
     * @param bool $useEncoding
     * @return HttpResponse
     */
    public function put($path, $params = [], $useEncoding = true)
    {
        $this->setBodyParams($params);
        $this->setOptions([
            CURLOPT_CUSTOMREQUEST => 'PUT',
        ]);

        return $this->send($path, $useEncoding);
    }

    /**
     * PUT方式提交json数据
     *
     * @param $path
     * @param array $params
     * @param bool $useEncoding
     * @return HttpResponse
     */
    public function putJson($path, $params = [], $useEncoding = true)
    {
        $this->setHeader('Content-Type', 'application/json');
        return $this->put($path, json_encode($params, JSON_UNESCAPED_UNICODE), $useEncoding);
    }

    /**
     * PATCH方式请求
     *
     * @param $path
     * @param array $params
     * @param bool $useEncoding
     * @return HttpResponse
     */
    public function patch($path, $params = [], $useEncoding = true)
    {
        $this->setBodyParams($params);
        $this->setOptions([
            CURLOPT_CUSTOMREQUEST => 'PATCH',
        ]);

        return $this->send($path, $useEncoding);
    }

    /**
     * PATCH方式提交json数据
     *
     * @param $url
     * @param array $params
     * @param bool $useEncoding
     * @return HttpResponse
     */
    public function patchJson($url, $params = [], $useEncoding = true)
    {
        $this->setHeader('Content-Type', 'application/json');
        return $this->patch($url, json_encode($params, JSON_UNESCAPED_UNICODE), $useEncoding);
    }

    /**
     * 发送请求并返回新类
     *
     * @param $path
     * @param $useEncoding
     * @return HttpResponse
     */
    private function send($path = '', $useEncoding = true)
    {
        //处理query参数
        if ($this->queryParams) {
            $path .= '?' . (is_array($this->queryParams) ? http_build_query($this->queryParams) : $this->queryParams);
        }

        //处理url
        $this->setOption(CURLOPT_URL, $this->resolveUrl($path));

        //处理header
        $this->resolveHeader();

        //处理body正文，有文件则不encode
        $this->resolveBody($useEncoding);

        //处理是否需要头部及正文并设置curl参数
        if ($this->fullResponse) {
            $this->setOption(CURLOPT_HEADER, true);
        }
        if ($this->onlyHeader) {
            $this->setOption(CURLOPT_NOBODY, true);
        }
        @curl_setopt_array($this->ch, $this->options);

        return $this->resolveResponse();
    }

    /**
     * 处理头信息及返回头信息并返回响应对象
     *
     * @return HttpResponse
     */
    private function resolveResponse()
    {
        //处理头部基础信息
        $response = new HttpResponse();
        $response->body = curl_exec($this->ch);
        if ($response->body === false) {
            $response->error = curl_error($this->ch);
        }
        $response->header->statusCode = curl_getinfo($this->ch, CURLINFO_HTTP_CODE);
        $response->header->contentType = curl_getinfo($this->ch, CURLINFO_CONTENT_TYPE);
        $response->header->requestUrl = curl_getinfo($this->ch, CURLINFO_EFFECTIVE_URL);
        $response->header->requestMethod = $this->options[CURLOPT_CUSTOMREQUEST];
        $response->header->queryParams = $this->queryParams;
        $response->header->bodyParams = $this->bodyParams;
        $response->header->totalTime = curl_getinfo($this->ch, CURLINFO_TOTAL_TIME);

        //处理返回头信息
        if ($this->fullResponse) {
            $headerSize = curl_getinfo($this->ch, CURLINFO_HEADER_SIZE);
            $headerContent = substr($response->body, 0, $headerSize);
            $response->body = substr($response->body, $headerSize, -1);
            $headerContent = array_filter(explode("\r\n", $headerContent));

            foreach ($headerContent as $field) {
                if (!is_array($field)) {
                    $field = array_map('trim', explode(':', $field, 2));
                }
                if (count($field) == 2) {
                    $response->responseHeader[$field[0]] = $field[1];
                }
            }
        }
        return $response;
    }

    //临时
    public function deleteJsonBody($url, $params = [], $useEncoding = true, $queryParams = [])
    {
        $this->setBodyParams($params, true);
        $this->setQueryParams($queryParams);
        $this->setHeader('Content-Type', 'application/json');
        $this->setOptions([
            CURLOPT_CUSTOMREQUEST => 'DELETE',
        ]);
        return $this->send($url, $useEncoding);
    }

    //销毁
    public function __destruct()
    {
        $this->headerParams = [];
        $this->options = [];
        curl_close($this->ch);
    }
}

class HttpResponse
{

    public $body;
    public $header;
    public $error;
    public $responseHeader;

    public function __construct()
    {
        $this->header = new HttpHeader();
    }

    //检查http返回状态是否成功(2XX)
    public function isSuccess()
    {
        if (!isset($this->header->statusCode)) {
            return false;
        }
        return substr($this->header->statusCode, 0, 1) == 2;
    }

    //转化body为数组
    public function toArray()
    {
        return $this->decodeJson(true);
    }

    //转化body为对象
    public function toObject()
    {
        return $this->decodeJson(false);
    }

    //转化body中json字符串
    private function decodeJson($toArray = false)
    {
        if (!$this->body) {
            return $toArray ? [] : new \stdClass();
        }
        if (json_decode($this->body) === false) {
            return false;
        }
        return json_decode($this->body, $toArray);
    }

}

class HttpHeader
{

    public $statusCode;
    public $contentType;
    public $requestUrl;
    public $requestMethod;
    public $queryParams;
    public $bodyParams;
    public $totalTime;

}