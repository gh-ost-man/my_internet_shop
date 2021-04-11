<?php
    use yii\helpers\Url;

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
    $this->title = $tovar['name'];
    $this->params['breadcrumbs'][] = ['label' => $category->name, 'url' => [$category->id . 'view']];
    $this->params['breadcrumbs'][] = $this->title;
?>


<style>
    * {
        margin: 0;
        padding: 0;
    }

    html,
    body {
        height: 100%;
        /* for touch screen laptop */
        touch-action: none; 
    }
    body {
        /* overflow: hidden; */
        /* display: -webkit-box; */
        /* display: -ms-flexbox; */
        /* display: flex; */
        background: #111;
        -webkit-perspective: 1000px; 
        perspective: 1000px; 
        -webkit-transform-style: preserve-3d; 
        transform-style: preserve-3d;   
    }

    #drag-container, #spin-container {
        position: relative;
        display: -webkit-box;
        display: -ms-flexbox;
        width: 300px;
        height: 300px;
        display: flex;
        margin: auto;
        -webkit-transform-style: preserve-3d;
                transform-style: preserve-3d;
        -webkit-transform: rotateX(-10deg);
                transform: rotateX(-10deg);
    }

    #drag-container img, #drag-container video {
        -webkit-transform-style: preserve-3d;
                transform-style: preserve-3d;
        position: absolute;
        left: 0;
        top: 0;
        width: 150px;
        height: 150px;
        /* width: 100%;
        height: 100%; */
        line-height: 200px;
        font-size: 50px;
        text-align: center;
        /* -webkit-box-shadow: 0 0 8px #fff;
                box-shadow: 0 0 8px #fff; */
        /* -webkit-box-reflect: below 10px linear-gradient(transparent, transparent, #0005); */
    }

    #drag-container img:hover, #drag-container video:hover {
        box-shadow: 0 0 15px #fffd;
        /* -webkit-box-shadow: 0 0 15px #fffd;
               
        -webkit-box-reflect: below 10px linear-gradient(transparent, transparent, #0007); */
    }

    #drag-container p {
        font-family: Serif;
        position: absolute;
        top: 100%;
        left: 50%;
        -webkit-transform: translate(-50%,-50%) rotateX(90deg);
                transform: translate(-50%,-50%) rotateX(90deg);
        color: #fff;
    }

    #ground {
        width: 900px;
        height: 900px;
        position: absolute;
        top: 100%;
        left: 50%;
        -webkit-transform: translate(-50%,-50%) rotateX(90deg);
                transform: translate(-50%,-50%) rotateX(90deg);
        background: -webkit-radial-gradient(center center, farthest-side , #9993, transparent);
    }

    #music-container {
        position: absolute;
        top: 0;
        left: 0;
    }

    @-webkit-keyframes spin {
        from{
            -webkit-transform: rotateY(0deg);
                    transform: rotateY(0deg);
        } to{
            -webkit-transform: rotateY(360deg);
                    transform: rotateY(360deg);
        }
    }

    @keyframes spin {
        from{
            -webkit-transform: rotateY(0deg);
                    transform: rotateY(0deg);
        } to{
            -webkit-transform: rotateY(360deg);
                    transform: rotateY(360deg);
        }
    }
    @-webkit-keyframes spinRevert {
        from{
            -webkit-transform: rotateY(360deg);
                    transform: rotateY(360deg);
        } to{
            -webkit-transform: rotateY(0deg);
                    transform: rotateY(0deg);
        }
    }
    @keyframes spinRevert {
        from{
            -webkit-transform: rotateY(360deg);
                    transform: rotateY(360deg);
        } to{
            -webkit-transform: rotateY(0deg);
                    transform: rotateY(0deg);
        }
    }
</style>


<div class="row mb-5">
    <div class="col-md-12 ">
        <div id="drag-container">
            <div id="spin-container">
                <?php if (count(json_decode($tovar['url_image'], true) )<= 2) : ?>
                    <?php foreach(json_decode($tovar['url_image'], true) as $image) : ?>
                                <img src="/<?= $image ?>" alt="...">
                    <?php endforeach ?>
                    <?php foreach(json_decode($tovar['url_image'], true) as $image) : ?>
                                <img src="/<?= $image ?>" alt="...">
                    <?php endforeach ?>
                <?php endif ?>
                <?php foreach(json_decode($tovar['url_image'], true) as $image) : ?>
                                <img src="/<?= $image ?>" alt="...">
                <?php endforeach ?>    
            </div>
            <div id="ground"></div>
        </div>
    </div>
</div>
<h1 class="text-white"><?= $tovar['name']?></h1>
<p class="text-white"><?= $tovar['description']?></p>

<div class="row mt-5">
    
    <div class="col-md-4 ">
        <!-- <div>
            <img src="/<?= json_decode($tovar['url_image'], true)[0]?>" style="width: 300px" alt="">
        </div> -->
       
        <div id="carouselExampleControls" class="carousel slide " data-ride="carousel" >
            <div class="carousel-inner ">
                <div class="carousel-item active">
                    <img src="/<?= json_decode($tovar['url_image'], true)[0] ?>" class="d-block w-100" style=" height: 300px" alt="...">
                </div>
                <?php foreach(json_decode($tovar['url_image'], true) as $image) : ?>
                    <div class="carousel-item">
                        <img src="/<?= $image ?>" class="d-block w-100"  style=" height: 300px" alt="...">
                    </div>
                <?php endforeach ?>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

    </div>
    <div class="col-md-6">
        <?php if($discount > 0 ) { $total = ($tovar['price'] / 100) * $discount; ?>
            <h3 class="text-secondary" style="text-decoration: line-through;">Price:  <span><?= $tovar['price'] ?></span>  $</h3>
            <h2 class="text-white">Price:  <span><?= $total ?></span> $</h2>
        <?php } else { ?>  
            <h1 class="text-white">Price:  <span><?= $tovar['price'] ?></span>  $</h1>
        <?php } ?>
        <?php if (Yii::$app->user->id != null) :?>
        <a class="btn btn-success w-25" href="<?= Url::to(['tovar/'. $tovar['id'] .'add-item']) ?>">
            <i class="fas fa-shopping-cart"></i>
            Buy
        </a>
        <?php endif ?>
    </div>
</div>

<script src="https://kit.fontawesome.com/85e3aaf13e.js" crossorigin="anonymous"></script>

<script>
    var radius = 240;
    var autoRotate = true;
    var rotateSpeed = -60;
    var imgWidth = 120; 
    var imgHeight = 170;


    var bgMusicURL = 'https://api.soundcloud.com/tracks/143041228/stream?client_id=587aa2d384f7333a886010d5f52f302a';
    var bgMusicControls = true;

    setTimeout(init, 100);

    var obox = document.getElementById('drag-container');
    var ospin = document.getElementById('spin-container');
    var aImg = ospin.getElementsByTagName('img');
    var aVid = ospin.getElementsByTagName('video');
    var aEle = [...aImg, ...aVid];


    ospin.style.width = imgWidth + "px";
    ospin.style.height = imgHeight + "px";


    var ground = document.getElementById('ground');
    ground.style.width = radius * 3 + "px";
    ground.style.height = radius * 3 + "px";

    function init(delayTime) {
    for (var i = 0; i < aEle.length; i++) {
        aEle[i].style.transform = "rotateY(" + (i * (360 / aEle.length)) + "deg) translateZ(" + radius + "px)";
        aEle[i].style.transition = "transform 1s";
        aEle[i].style.transitionDelay = delayTime || (aEle.length - i) / 4 + "s";
    }
    }

    function applyTranform(obj) {

    if(tY > 180) tY = 180;
    if(tY < 0) tY = 0;

    obj.style.transform = "rotateX(" + (-tY) + "deg) rotateY(" + (tX) + "deg)";
    }

    function playSpin(yes) {
    ospin.style.animationPlayState = (yes?'running':'paused');
    }

    var sX, sY, nX, nY, desX = 0,
        desY = 0,
        tX = 0,
        tY = 10;


    if (autoRotate) {
    var animationName = (rotateSpeed > 0 ? 'spin' : 'spinRevert');
    ospin.style.animation = `${animationName} ${Math.abs(rotateSpeed)}s infinite linear`;
    }


    if (bgMusicURL) {
    document.getElementById('music-container').innerHTML += `
    <audio src="${bgMusicURL}" ${bgMusicControls? 'controls': ''} autoplay loop>    
    <p>If you are reading this, it is because your browser does not support the audio element.</p>
    </audio>
    `;
    }

    document.onpointerdown = function (e) {
    clearInterval(obox.timer);
    e = e || window.event;
    var sX = e.clientX,
        sY = e.clientY;

    this.onpointermove = function (e) {
        e = e || window.event;
        var nX = e.clientX,
            nY = e.clientY;
        desX = nX - sX;
        desY = nY - sY;
        tX += desX * 0.1;
        tY += desY * 0.1;
        applyTranform(obox);
        sX = nX;
        sY = nY;
    };

    this.onpointerup = function (e) {
        obox.timer = setInterval(function () {
        desX *= 0.95;
        desY *= 0.95;
        tX += desX * 0.1;
        tY += desY * 0.1;
        applyTranform(obox);
        playSpin(false);
        if (Math.abs(desX) < 0.5 && Math.abs(desY) < 0.5) {
            clearInterval(obox.timer);
            playSpin(true);
        }
        }, 17);
        this.onpointermove = this.onpointerup = null;
    };

    return false;
    };

    document.onmousewheel = function(e) {
    e = e || window.event;
    var d = e.wheelDelta / 20 || -e.detail;
    radius += d;
    init(1);
    };

</script>