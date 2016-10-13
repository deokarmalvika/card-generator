<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 13.10.2016
 * Time: 15:54
 */

namespace CardGenerator\Elements;


use CardGenerator\Base\Position;
use CardGenerator\Base\Size;

class Image extends CardObject implements Arrayable, CsvInterface, ApplyToImage, CardObjectInterface
{
    protected $type = '';
    protected $opacity = 100;
    protected $path = '';

    /**
     * Image constructor.
     *
     */
    public function __construct()
    {
        parent::__construct(new Position(0, 0), new Size(0, 0));
    }

    public static function make()
    {
        return new static();
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return $this
     */
    public function type($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return int
     */
    public function getOpacity()
    {
        return $this->opacity;
    }

    /**
     * @param int $opacity
     *
     * @return $this
     */
    public function opacity($opacity)
    {
        $this->opacity = (int)$opacity;
        if($this->opacity === 0 || $this->opacity > 100) {
            $this->opacity = 100;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     *
     * @return $this
     */
    public function path($path)
    {
        if(file_exists($path)) {
            $this->path = $path;
        }

        return $this;
    }

    /**
     * @param resource $imageDest
     */
    public function putOnImage($imageDest)
    {
        if ($this->path !== '') {
            if ($this->type === 'png') {
                $image = imagecreatefrompng($this->path);
            } elseif ($this->type === 'jpg') {
                $image = imagecreatefromjpeg($this->path);
            } elseif ($this->type === 'gif') {
                $image = imagecreatefromgif($this->path);
            }
            if (isset($image)) {
                imagecopymerge(
                    $imageDest,
                    $image,
                    $this->position->x(),
                    $this->position->y(),
                    0,
                    0,
                    $this->size->w(),
                    $this->size->h(),
                    $this->opacity
                );
            }
        }
    }

    public function toArray()
    {
        return array_merge(parent::toArray(), [
            'type' => $this->type,
            'path' => $this->path,
            'opacity' => $this->opacity,
        ]);
    }

    public function getParamNames()
    {
        return [
            'Тип блока',
            'Путь до картинки',
            'Тип картинки',
            'Прозрачность картинки',
            'Позиция (X)',
            'Позиция (Y)',
            'Ширина',
            'Высота',
        ];
    }

    public function toCsvArray()
    {
        return array_merge([
            'image',
            $this->path,
            $this->type,
            $this->opacity,
        ], $this->position, $this->size->toArray());
    }
}