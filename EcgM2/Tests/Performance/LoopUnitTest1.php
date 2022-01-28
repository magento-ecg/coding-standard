<?php
declare(strict_types=1);

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilderFactory;

class LoopUnitTest1
{
    private array $productSkus = ['123', '234'];

    private ProductRepositoryInterface $repository;

    private SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory;

    public function go()
    {
        for ($i = 0; $i < count($this->productSkus); $i++) {
            $a = $this->repository->get($this->getSkuById($i));
        }

        $i = 0;
        $searchCriteriaBuilder = $this->searchCriteriaBuilderFactory->create();
        do {
            $a = $this->repository->get($this->getSkuById($i));
            $b = $this->repository->getById($i);
            $c = $this->repository->getList($searchCriteriaBuilder->create());

            $i++;
        } while (isset($this->productSkus[$i]));

        $size = count($this->productSkus);
        for ($i = 0; $i < $size; $i++) {
            $a = $this->repository->get($this->getSkuById($i));
            $b = $this->repository->getById($i);
            $c = $this->repository->getList($searchCriteriaBuilder->create());
        }

        foreach ($this->productSkus as $id => $sku) {
            $a = $this->repository->get($this->getSkuById($id));
            $b = $this->repository->getById($id);
            $c = $this->repository->getList($searchCriteriaBuilder->create());
        }

        $i = 0;
        while (isset($this->productSkus[$i])) {
            $a = $this->repository->get($this->getSkuById($i));
            $b = $this->repository->getById($i);
            $c = $this->repository->getList($searchCriteriaBuilder->create());
        }
    }

    private function getSkuById(int $id)
    {
        return $this->productSkus[$id] ?? '';
    }
}
