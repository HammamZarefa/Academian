<div class="flex justify-center pt-8 sm:justify-start sm:pt-0">     
        <nav class="btn-pluss-wrapper">
            <div href="#" class="btn-pluss">
            <ul>
                @foreach($available_locales as $locale_name => $available_locale)
                @if($available_locale === $current_locale)
                <li class="active`"><a href="#about"> {{ $locale_name }}</a></li>
                @else
                <li><a href="#blog"> {{ $locale_name }}</a></li>
                @endif
                @endforeach
            </ul>
        </div>
        </nav>
</div>
<style>
    .current_locale{
        color:#fff
    }
    section {
	 position: relative;
}
 .btn-pluss {
	 overflow: hidden;
	 position: absolute;
	 display: block;
	 padding-left: 5px;
	 padding-right: 5px;
	 border-radius: 22px;
	 width: 30px;
	 margin: 0 auto;
	 background-color: transparent;
	 transition: width 0.3s 0.5s ease, border-radius 1.1s ease;
     z-index: 999;
     top: -5px;
     right: 0;
}
.btn-pluss:hover{
    background-color: white;
	box-shadow: 1px 3px 10px #555;
}
 .btn-pluss a {
	 display: block;
	 position: relative;
	 color: #026bc3;
	 text-decoration: none;
	 overflow: hidden;
	 padding: 5px 3px;
	 border-radius: 5px;
	 height: 100%;
	 font-size:16px;
}
 .btn-pluss a:hover {
	 text-decoration: inherit;
	 color: white;
	 background-color: #026bc3;
	 transition: background-color 0.5s ease;
}
 .btn-pluss:after {
	 content: '\f0ac';
	 position: absolute;
	 top: 50%;
	 left: 50%;
	 display: block;
	 height: 20px;
	 width: 20px;
	 border-radius: 100%;
	 line-height: 20px;
	 text-align: center;
	 font-size: 1.1rem;
	 background-color: #026bc3;
     font-size: 18px;
	 color: white;
	 transform: translateY(-50%) translateX(-50%);
	 transition: all 0.3s 0.5s ease;
	 cursor: pointer;
	 cursor: hand;
     font-family: "Font Awesome 5 Free";
     vertical-align: middle;
     font-weight: 900;
  
}
 .btn-pluss ul {
	 opacity: 0;
     padding: 0;
}
 .btn-pluss ul {
	 margin-top: 10px;
	 opacity: 0;
	 width: 100%;
	 margin-left: 0px;
	 transition: all 0.5s ease;
	 text-align: center;
	 font-size: 0.9rem;
}
 .btn-pluss ul li {
	 background-color: #e4e4e4;
	 margin-top: 5px;
	 border-radius: 5px;
	 width: 100%;
	 height: 0px;
	 overflow: hidden;
	 transition: height 1s ease;
}

 .btn-pluss-wrapper:hover .btn-pluss {
	 width: 150px;
	 border-radius: 15px;
	 padding-bottom: 5px;
	 transition: width 0.3s ease, border-radius 0.3s ease, padding-bottom 0.3s ease;
     top: 0;
}
 .btn-pluss-wrapper:hover .btn-pluss::after {
	 transition: all 0.3s ease;
	 left: 50%;
	 top: 10px;
	 transform: translateY(-5px) translateX(-50%);
}
 .btn-pluss-wrapper:hover .btn-pluss ul {
	 opacity: 1;
	 margin-top: 30px;
	 transition: all 1s ease;
}
 .btn-pluss-wrapper:hover .btn-pluss li {
	 height: 25px;
	 transition: height 1s ease;
}
 .btn-pluss-wrapper:hover .btn-pluss li:hover {
	 border-bottom: 1px solid #d2c9c9;
}
 @keyframes jump {
	 0% {
		 transform: translateY(3px);
	}
	 50% {
		 transform: translateY(-15px);
	}
	 100% {
		 transform: translateY(3px);
	}
}
 
</style>