<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\select2\Select2;
use kartik\widgets\FileInput;
use yii\helpers\Url;

$this->title = 'Реклама';
$this->params['breadcrumbs'][] = ['label' => 'Реклами', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCss(
    "   
        .gallery
        {
            width: 100%;
        }

        .gallery-container {
            align-items: center;
            display: flex;
            height: 400px;
            margin: 0 auto;
            max-width: 1000px;
            position: relative;
            background: black;
        }

        .gallery-item {
            height: 150px;
            opacity: 0;
            position: absolute;
            transition: all 0.3s ease-in-out;
            width: 150px;
            z-index: 0;
        }

        .gallery-item-1 {
            left: 15%;
            opacity: .4;
            transform: translateX(-50%);
        }

        .gallery-item-2,
        .gallery-item-4 
        {
            height: 200px;
            opacity: 1;
            width: 200px;
            z-index: 1;
        }

        .gallery-item-2
        {
            left: 30%;
            transform: translateX(-50%);
        }

        .gallery-item-3
        {
            box-shadow: 0 0 30px rgba(255, 255, 255, 0.6), 0 0 60px rgba(255, 255, 255, 0.45), 0 0 110px rgba(255, 255, 255, 0.25), 0 0 100px rgba(255, 255, 255, 0.1);
            height: 300px;
            opacity: 1;
            left: 50%;
            transform: translateX(-50%);
            width: 400px;
            z-index: 2;
        }

        .gallery-item-4 
        {
            left: 70%;
            transform: translateX(-50%);
        }

        .gallery-item-5 
        {
            left: 85%;
            opacity: .4;
            transform: translateX(-50%);
        }

        .gallery-controls 
        {
            display: flex;
            justify-content: center;
            margin: 30px 0;
        }

        .gallery-controls button 
        {
            background-color: transparent;
            border: 0;
            cursor: pointer;
            font-size: 16px;
            margin: 0 20px;
            padding: 0 12px;
            text-transform: capitalize;
        }

        .gallery-controls button:focus 
        {
            outline: none;
        }

        .gallery-controls-previous 
        {
            position: relative;
        }

        .gallery-controls-previous::before 
        {
            border: solid #000;
            border-width: 0 2px 2px 0;
            content: '';
            display: inline-block;
            height: 4px;
            left: -10px;
            padding: 2px;
            position: absolute;
            top: 0;
            transform: rotate(135deg) translateY(-50%);
            transition: left 0.15s ease-in-out;
            width: 4px;
        }

        .gallery-controls-previous:hover::before 
        {
            left: -18px;
        }

        .gallery-controls-next 
        {
            position: relative;
        }

        .gallery-controls-next::before 
        {
            border: solid #000;
            border-width: 0 2px 2px 0;
            content: '';
            display: inline-block;
            height: 4px;
            padding: 2px;
            position: absolute;
            right: -10px;
            top: 50%;
            transform: rotate(-45deg) translateY(-50%);
            transition: right 0.15s ease-in-out;
            width: 4px;
        }

        .gallery-controls-next:hover::before 
        {
            right: -18px;
        }

        .gallery-nav 
        {
            bottom: -15px;
            display: flex;
            justify-content: center;
            list-style: none;
            padding: 0;
            position: absolute;
            width: 100%;
        }

        .gallery-nav li 
        {
            background: #ccc;
            border-radius: 50%;
            height: 10px;
            margin: 0 16px;
            width: 10px;
        }

        .gallery-nav li.gallery-item-selected 
        {
            background: #555;
        }
    "
);

$js = <<< JS
const galleryContainer = document.querySelector('.gallery-container');
    const galleryControlsContainer = document.querySelector('.gallery-controls');
    const galleryControls = ['previous', 'next'];
    const galleryItems = document.querySelectorAll('.gallery-item');

    class Carousel {
    constructor(container, items, controls) {
        this.carouselContainer = container;
        this.carouselControls = controls;
        this.carouselArray = [...items];
    }

    // Update css classes for gallery
    updateGallery() {
        this.carouselArray.forEach(el => {
        el.classList.remove('gallery-item-1');
        el.classList.remove('gallery-item-2');
        el.classList.remove('gallery-item-3');
        el.classList.remove('gallery-item-4');
        el.classList.remove('gallery-item-5');
        });

        this.carouselArray.slice(0, 5).forEach((el, k) => {
        el.classList.add(`gallery-item-` + (k + 1));
        });
    }

    // Update the current order of the carouselArray and gallery
    setCurrentState(direction) {

        if (direction.className == 'gallery-controls-previous') {
        this.carouselArray.unshift(this.carouselArray.pop());
        } else {
        this.carouselArray.push(this.carouselArray.shift());
        }
        
        this.updateGallery();
    }


    // Construct the carousel controls
    setControls() {
        this.carouselControls.forEach(control => {
        galleryControlsContainer.appendChild(document.createElement('button')).className = `gallery-controls-` + control;

        document.querySelector(`.gallery-controls-` + control).innerText = control;
        });
    }
    
    // Add a click event listener to trigger setCurrentState method to rearrange carousel
    useControls() {
        const triggers = [...galleryControlsContainer.childNodes];

        triggers.forEach(control => {
            control.addEventListener('click', e => {
                e.preventDefault();
                
                this.setCurrentState(control);
            });
        });
    }
    }

    const exampleCarousel = new Carousel(galleryContainer, galleryItems, galleryControls);

    exampleCarousel.setControls();
    // exampleCarousel.setNav();
    exampleCarousel.useControls();


JS;

$this->registerJS($js);

$i = 1;
?>

<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div>
            <h2><?= $promotion->name?></h2>
            <p><?= $promotion->description ?></p>
        </div>
        <div class="gallery-container">
                <?php if (count($images)<3) { 
                    for($j = 0; $j < 5; $j++) : ?>
                        <?php foreach($images as $image) : ?>
                            <img class="gallery-item gallery-item-<?= $i++ ?>" src="../../<?= $image ?>" data-index="1">
                        <?php endforeach ?>
                        <?php foreach($images as $image) : ?>
                            <img class="gallery-item gallery-item-<?= $i++ ?>" src="../../<?= $image ?>" data-index="1">
                        <?php endforeach ?>
                    <?php endfor ?>
                <?php } else { ?>
                    <?php foreach($images as $image) : ?>
                        <img class="gallery-item gallery-item-<?= $i++ ?>" src="../../<?= $image ?>" data-index="1">
                    <?php endforeach ?>
                <?php } ?>
            </div>
            <div class="gallery-controls"></div>
        </div>
    </div>
    <div class="col-md-2"></div>
</div>