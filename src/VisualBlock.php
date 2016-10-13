<?php
/**
 * Date: 11.10.16
 * Time: 13:46
 */

namespace CardGenerator;


class VisualBlock
{
    protected $backgroundColor = null;
    protected $backgroundColorRaw = null;
    protected $backgroundImage;
    protected $backgroundImageRaw;
    protected $text = '';
    protected $position = ['x' => 0, 'y' => 0];
    protected $size = ['w' => 0, 'h' => 0];
    protected $border = ['color' => null, 'colorRaw' => null, 'width' => 0];

    protected $image;

    /**
     * VisualBlock constructor.
     *
     * @param       $image
     * @param array $data
     */
    public function __construct($image, array $data = [])
    {
        $this->image = $image;
        if ($data['background-color'] === '') {
            $data['background-color'] = null;
        } else {
            $data['background-color'] = explode(' ', $data['background-color']);
            $this->backgroundColor = GdHelper::colorFromArray($this->image, $data['background-color']);
        }
        $this->backgroundImage = $this->copyFiles($data['background-image']);
        if($this->backgroundImage !== []) {
            $this->backgroundImage['opacity'] = (int)$data['background-image-opacity'];
        }
        $this->text = (string)$data['text'] ?: '';
        if (isset($data['border']) && $data['border'] !== '') {
            $data['border'] = explode(' ', $data['border']);
            $this->border['width'] = (int)array_shift($data['border']);
            $this->border['color'] = GdHelper::colorFromArray($this->image, $data['border']);
        }
        $this->position['x'] = (int)$data['x'];
        $this->position['y'] = (int)$data['y'];
        $this->size['w'] = (int)$data['w'];
        $this->size['h'] = (int)$data['h'];
    }

    protected function copyFiles($data)
    {
        if($data['name'] === ''){
            return [];
        }
        $imagePath = dirname(__DIR__) . '/loaded/' . $data['name'];
        if(move_uploaded_file($data['tmp_name'], $imagePath)){
            return ['path' => $imagePath, 'type' => substr($data['name'], strrpos($data['name'], '.') + 1)];
        }
        return [];
    }

    public function setOnImage()
    {
        $this->writeBackground();
        if ($this->backgroundImage !== []) {
            if($this->backgroundImage['type'] === 'png'){
                $image = imagecreatefrompng($this->backgroundImage['path']);
            }elseif($this->backgroundImage['type'] === 'jpg'){
                $image = imagecreatefromjpeg($this->backgroundImage['path']);
            }elseif($this->backgroundImage['type'] === 'gif'){
                $image = imagecreatefromgif($this->backgroundImage['path']);
            }
            if(isset($image)) {
                imagecopymerge(
                    $this->image,
                    $image,
                    $this->position['x'],
                    $this->position['y'],
                    0,
                    0,
                    $this->size['w'],
                    $this->size['h'],
                    $this->backgroundImage['opacity']
                );
            }
        }
        $this->writeBorder();
    }

    protected function writeBackground()
    {
        if ($this->backgroundColor !== null && $this->backgroundColor !== false) {
            imagefilledrectangle(
                $this->image,
                $this->position['x'],
                $this->position['y'],
                $this->position['x'] + $this->size['w'],
                $this->position['y'] + $this->size['h'],
                $this->backgroundColor
            );
        }
    }

    protected function writeBorder()
    {
        if (
            $this->border !== null &&
            $this->border['width'] !== 0 &&
            $this->border['color'] !== null &&
            $this->border['color'] !== false
        ) {
            for ($i = 0; $i < $this->border['width']; $i++) {
                imagerectangle(
                    $this->image,
                    $this->position['x'] + $i,
                    $this->position['y'] + $i,
                    $this->position['x'] + $this->size['w'] - $i,
                    $this->position['y'] + $this->size['h'] - $i,
                    $this->border['color']
                );
            }
        }
    }

    public function toArray($file)
    {
        return [];
    }
}