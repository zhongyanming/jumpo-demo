<?php
namespace backend\services;

use backend\models\Supplier;
use backend\models\SupplierSearch;
use Exception;

class SupplierService
{
    /**
     * 用于GridView的状态选项
     * @return array
     */
    public function getStatusOptionsForGridView(): array
    {
        return Supplier::T_STATUS_TXT_ARR;
    }

    /**
     * id范围标识选项
     * @return string[]
     */
    public function getIdRangeTags(): array
    {
        return [
            '=' => '=',
            '>' => '>',
            '<' => '<',
            '>=' => '>=',
            '<=' => '<='
        ];
    }

    /**
     * 导出
     * @param $params
     * @return string
     * @throws Exception
     */
    public function export($params): string
    {
        // 是否导出所有过滤数据
        $selectAll = $params['select_all'] ?? 0;
        // 选中的id
        $ids = empty($selectAll) && !empty($params['ids']) ? $params['ids'] : null;

        if (empty($ids) && empty($selectAll)){
            throw new Exception('未选中导出数据');
        }

        // 过滤条件
        $filter = $params['filter'] ?? [];
        // 导出字段
        $columns = $params['columns'] ?? ['id'];

        // 获取查询构造器
        $query = (new SupplierSearch())->search($filter)->query;

        // 过滤选中id
        $query->andFilterWhere(['in', 'id', $ids]);

        // 获取数据
        $data = $query->select($columns)->all();

        // 构建csv文件
        return $this->buildCSV($columns, $data);
    }

    /**
     * 构建csv文件
     * @param $titleArr
     * @param $data
     * @return string
     */
    protected function buildCSV($titleArr, $data): string
    {
        // 文件名
        $fileName = '供应商'.date('YmdHis').'.csv';

        // 表头
        $head = implode(',', $titleArr)."\n";

        // 表体
        $body = '';
        if (!empty($data)){
            /** @var Supplier $row */
            foreach ($data as $row){
                foreach ($titleArr as $key => $value){
                    if ($key != 0) $body.= ',';
                    $body .= $row->$value;
                }
                $body .= "\n";
            }
        }

        $info = iconv('utf-8', 'GBK//ignore', $head.$body);

        file_put_contents('./tmp/'.$fileName, $info);

        return '/tmp/'.$fileName;
    }
}