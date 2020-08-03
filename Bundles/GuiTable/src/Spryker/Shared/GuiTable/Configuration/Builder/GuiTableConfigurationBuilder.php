<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Shared\GuiTable\Configuration\Builder;

use ArrayObject;
use Generated\Shared\Transfer\DateRangeGuiTableFilterTypeOptionsTransfer;
use Generated\Shared\Transfer\GuiTableColumnConfigurationTransfer;
use Generated\Shared\Transfer\GuiTableConfigurationTransfer;
use Generated\Shared\Transfer\GuiTableDataSourceConfigurationTransfer;
use Generated\Shared\Transfer\GuiTableFiltersConfigurationTransfer;
use Generated\Shared\Transfer\GuiTableFilterTransfer;
use Generated\Shared\Transfer\GuiTablePaginationConfigurationTransfer;
use Generated\Shared\Transfer\GuiTableRowActionsConfigurationTransfer;
use Generated\Shared\Transfer\GuiTableRowActionTransfer;
use Generated\Shared\Transfer\GuiTableSearchConfigurationTransfer;
use Generated\Shared\Transfer\OptionSelectGuiTableFilterTypeOptionsTransfer;
use Generated\Shared\Transfer\SelectGuiTableFilterTypeOptionsTransfer;
use Spryker\Shared\GuiTable\Exception\InvalidConfigurationException;

class GuiTableConfigurationBuilder implements GuiTableConfigurationBuilderInterface
{
    /**
     * @see https://angular.io/api/common/DatePipe for details.
     */
    protected const DEFAULT_UI_DATE_FORMAT = 'dd.MM.y';

    /**
     * @var \Generated\Shared\Transfer\GuiTableColumnConfigurationTransfer[]
     */
    protected $columns;

    /**
     * @var \Generated\Shared\Transfer\GuiTableFilterTransfer[]
     */
    protected $filters = [];

    /**
     * @var \Generated\Shared\Transfer\GuiTableRowActionTransfer[]
     */
    protected $rowActions = [];

    /**
     * @var string
     */
    protected $rowOnClickIdAction;

    /**
     * @var string
     */
    protected $rowActionActionIdPath;

    /**
     * @var string
     */
    protected $dataSourceUrl;

    /**
     * @var int
     */
    protected $defaultPageSize;

    /**
     * @var string
     */
    protected $searchPlaceholder;

    /**
     * @param string $id
     * @param string $title
     * @param bool $isSortable
     * @param bool $isHideable
     *
     * @return $this
     */
    public function addColumnText(
        string $id,
        string $title,
        bool $isSortable,
        bool $isHideable
    ) {
        $guiTableColumnConfigurationTransfer = (new GuiTableColumnConfigurationTransfer())
            ->setId($id)
            ->setTitle($title)
            ->setType(static::COLUMN_TYPE_TEXT)
            ->setSortable($isSortable)
            ->setHideable($isHideable);

        $this->addColumn($guiTableColumnConfigurationTransfer);

        return $this;
    }

    /**
     * @param string $id
     * @param string $title
     * @param bool $isSortable
     * @param bool $isHideable
     *
     * @return $this
     */
    public function addColumnImage(
        string $id,
        string $title,
        bool $isSortable,
        bool $isHideable
    ) {
        $guiTableColumnConfigurationTransfer = (new GuiTableColumnConfigurationTransfer())
            ->setId($id)
            ->setTitle($title)
            ->setType(static::COLUMN_TYPE_IMAGE)
            ->setSortable($isSortable)
            ->setHideable($isHideable);

        $this->addColumn($guiTableColumnConfigurationTransfer);

        return $this;
    }

    /**
     * @param string $id
     * @param string $title
     * @param bool $isSortable
     * @param bool $isHideable
     * @param string|null $uiDateFormat
     *
     * @return $this
     */
    public function addColumnDate(
        string $id,
        string $title,
        bool $isSortable,
        bool $isHideable,
        ?string $uiDateFormat = null
    ) {
        $guiTableColumnConfigurationTransfer = (new GuiTableColumnConfigurationTransfer())
            ->setId($id)
            ->setTitle($title)
            ->setType(static::COLUMN_TYPE_DATE)
            ->setSortable($isSortable)
            ->setHideable($isHideable)
            ->addTypeOption('format', $uiDateFormat ?? static::DEFAULT_UI_DATE_FORMAT);

        $this->addColumn($guiTableColumnConfigurationTransfer);

        return $this;
    }

    /**
     * @param string $id
     * @param string $title
     * @param bool $isSortable
     * @param bool $isHideable
     * @param array|null $typeOptions
     * @param array|null $typeOptionsMappings
     *
     * @return $this
     */
    public function addColumnChip(
        string $id,
        string $title,
        bool $isSortable,
        bool $isHideable,
        ?array $typeOptions = [],
        ?array $typeOptionsMappings = []
    ) {
        $guiTableColumnConfigurationTransfer = (new GuiTableColumnConfigurationTransfer())
            ->setId($id)
            ->setTitle($title)
            ->setType(static::COLUMN_TYPE_CHIP)
            ->setSortable($isSortable)
            ->setHideable($isHideable);

        foreach ($typeOptions as $key => $typeOption) {
            $guiTableColumnConfigurationTransfer->addTypeOption($key, $typeOption);
        }

        foreach ($typeOptionsMappings as $key => $typeOptionsMapping) {
            $guiTableColumnConfigurationTransfer->addTypeOptionMapping($key, $typeOptionsMapping);
        }

        $this->addColumn($guiTableColumnConfigurationTransfer);

        return $this;
    }

    /**
     * @param string $id
     * @param string $title
     * @param bool $isSortable
     * @param bool $isHideable
     * @param array|null $typeOptions
     * @param array|null $typeOptionsMappings
     *
     * @return $this
     */
    public function addColumnChips(
        string $id,
        string $title,
        bool $isSortable,
        bool $isHideable,
        ?array $typeOptions = [],
        ?array $typeOptionsMappings = []
    ) {
        $guiTableColumnConfigurationTransfer = (new GuiTableColumnConfigurationTransfer())
            ->setId($id)
            ->setTitle($title)
            ->setType(static::COLUMN_TYPE_LIST)
            ->setSortable($isSortable)
            ->setHideable($isHideable)
            ->addTypeOption('type', static::COLUMN_TYPE_CHIP);

        foreach ($typeOptions as $key => $typeOption) {
            $guiTableColumnConfigurationTransfer->addTypeOption($key, $typeOption);
        }

        foreach ($typeOptionsMappings as $key => $typeOptionsMapping) {
            $guiTableColumnConfigurationTransfer->addTypeOptionMapping($key, $typeOptionsMapping);
        }

        $this->addColumn($guiTableColumnConfigurationTransfer);

        return $this;
    }

    /**
     * @param \Generated\Shared\Transfer\GuiTableColumnConfigurationTransfer $guiTableColumnConfigurationTransfer
     *
     * @throws \Spryker\Shared\GuiTable\Exception\InvalidConfigurationException
     *
     * @return void
     */
    protected function addColumn(GuiTableColumnConfigurationTransfer $guiTableColumnConfigurationTransfer): void
    {
        $columnId = $guiTableColumnConfigurationTransfer->getId();

        if (isset($this->columns[$columnId])) {
            throw new InvalidConfigurationException(sprintf('Column with id "%s" already exists', $columnId));
        }

        $this->columns[$columnId] = $guiTableColumnConfigurationTransfer;
    }

    /**
     * @param string $id
     * @param string $title
     * @param bool $isMultiselect
     * @param array $values select values in format of ['value1' => 'title1', 'value2' => 'title2']
     *
     * @return $this
     */
    public function addFilterSelect(
        string $id,
        string $title,
        bool $isMultiselect,
        array $values
    ) {
        $typeOptionTransfers = (new SelectGuiTableFilterTypeOptionsTransfer())->setMultiselect($isMultiselect);

        foreach ($values as $value => $optionTitle) {
            $optionTransfer = (new OptionSelectGuiTableFilterTypeOptionsTransfer())
                ->setValue($value)
                ->setTitle($optionTitle);
            $typeOptionTransfers->addValue($optionTransfer);
        }

        $this->filters[] = (new GuiTableFilterTransfer())
            ->setId($id)
            ->setTitle($title)
            ->setType(static::FILTER_TYPE_SELECT)
            ->setTypeOptions($typeOptionTransfers);

        return $this;
    }

    /**
     * @param string $id
     * @param string $title
     * @param string|null $placeholderFrom
     * @param string|null $placeholderTo
     *
     * @return $this
     */
    public function addFilterDateRange(
        string $id,
        string $title,
        ?string $placeholderFrom = null,
        ?string $placeholderTo = null
    ) {
        $guiTableFilterTransfer = (new GuiTableFilterTransfer())
            ->setId($id)
            ->setTitle($title)
            ->setType(static::FILTER_TYPE_DATE_RANGE);

        if ($placeholderFrom || $placeholderTo) {
            $guiTableFilterTransfer->setTypeOptions(
                (new DateRangeGuiTableFilterTypeOptionsTransfer())
                    ->setPlaceholderFrom($placeholderFrom)
                    ->setPlaceholderTo($placeholderTo)
            );
        }

        $this->filters[] = $guiTableFilterTransfer;

        return $this;
    }

    /**
     * @param string $id
     * @param string $title
     * @param string $url
     *
     * @return $this
     */
    public function addRowActionOpenFormOverlay(string $id, string $title, string $url)
    {
        $this->addRowAction($id, $title, static::ROW_ACTION_TYPE_FORM_OVERLAY, ['url' => $url]);

        return $this;
    }

    /**
     * @param string $id
     * @param string $title
     * @param string $url
     *
     * @return $this
     */
    public function addRowActionOpenPageOverlay(string $id, string $title, string $url)
    {
        $this->addRowAction($id, $title, static::ROW_ACTION_TYPE_HTML_OVERLAY, ['url' => $url]);

        return $this;
    }

    /**
     * @param string $id
     * @param string $title
     * @param string $type
     * @param string[] $options
     *
     * @throws \Spryker\Shared\GuiTable\Exception\InvalidConfigurationException
     *
     * @return void
     */
    protected function addRowAction(string $id, string $title, string $type, array $options): void
    {
        if (isset($this->rowActions[$id])) {
            throw new InvalidConfigurationException(sprintf('Row action with id "%s" already exists', $id));
        }

        $guiTableRowActionTransfer = (new GuiTableRowActionTransfer())
            ->setId($id)
            ->setTitle($title)
            ->setType($type)
            ->setTypeOptions($options);

        $this->rowActions[$id] = $guiTableRowActionTransfer;
    }

    /**
     * @param string $idAction
     *
     * @return $this
     */
    public function setRowClickAction(string $idAction)
    {
        $this->rowOnClickIdAction = $idAction;

        return $this;
    }

    /**
     * @param string $url
     *
     * @return $this
     */
    public function setDataSourceUrl(string $url)
    {
        $this->dataSourceUrl = $url;

        return $this;
    }

    /**
     * @param int $defaultPageSize
     *
     * @return $this
     */
    public function setDefaultPageSize(int $defaultPageSize)
    {
        $this->defaultPageSize = $defaultPageSize;

        return $this;
    }

    /**
     * @param string $searchPlaceholder
     *
     * @return $this
     */
    public function setSearchPlaceholder(string $searchPlaceholder)
    {
        $this->searchPlaceholder = $searchPlaceholder;

        return $this;
    }

    /**
     * @throws \Spryker\Shared\GuiTable\Exception\InvalidConfigurationException
     *
     * @return \Generated\Shared\Transfer\GuiTableConfigurationTransfer
     */
    public function createConfiguration(): GuiTableConfigurationTransfer
    {
        if (!$this->columns) {
            throw new InvalidConfigurationException('Table must have at least one column');
        }

        $guiTableConfigurationTransfer = new GuiTableConfigurationTransfer();

        $guiTableConfigurationTransfer->setColumns(new ArrayObject($this->columns));
        $guiTableConfigurationTransfer = $this->setFilters($guiTableConfigurationTransfer);
        $guiTableConfigurationTransfer = $this->setRowActions($guiTableConfigurationTransfer);

        if ($this->dataSourceUrl) {
            $guiTableConfigurationTransfer->setDataSource(
                (new GuiTableDataSourceConfigurationTransfer())->setUrl($this->dataSourceUrl)
            );
        }

        if ($this->defaultPageSize) {
            $guiTableConfigurationTransfer->setPagination(
                (new GuiTablePaginationConfigurationTransfer())->setDefaultSize($this->defaultPageSize)
            );
        }

        if ($this->searchPlaceholder) {
            $guiTableConfigurationTransfer->setSearch(
                (new GuiTableSearchConfigurationTransfer())
                    ->addSearchOption('placeholder', $this->searchPlaceholder)
            );
        }

        return $guiTableConfigurationTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\GuiTableConfigurationTransfer $guiTableConfigurationTransfer
     *
     * @return \Generated\Shared\Transfer\GuiTableConfigurationTransfer
     */
    protected function setFilters(GuiTableConfigurationTransfer $guiTableConfigurationTransfer): GuiTableConfigurationTransfer
    {
        $guiTableConfigurationTransfer->setFilters(
            (new GuiTableFiltersConfigurationTransfer())->setIsEnabled(false)
        );

        if ($this->filters) {
            $guiTableConfigurationTransfer->getFilters()
                ->setIsEnabled(true)
                ->setItems(new ArrayObject($this->filters));
        }

        return $guiTableConfigurationTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\GuiTableConfigurationTransfer $guiTableConfigurationTransfer
     *
     * @return \Generated\Shared\Transfer\GuiTableConfigurationTransfer
     */
    protected function setRowActions(GuiTableConfigurationTransfer $guiTableConfigurationTransfer): GuiTableConfigurationTransfer
    {
        $guiTableConfigurationTransfer->setRowActions(
            (new GuiTableRowActionsConfigurationTransfer())->setIsEnabled(false)
        );

        if ($this->rowActions) {
            $guiTableConfigurationTransfer->getRowActions()
                ->setIsEnabled(true)
                ->setActions(new ArrayObject($this->rowActions))
                ->setClick($this->rowOnClickIdAction);
        }

        return $guiTableConfigurationTransfer;
    }
}
