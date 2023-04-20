<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Project 4 Testing</title>
  <link rel="stylesheet" href="realestate.css">
  <script src="realestate.js"></script>
</head>
<body>
  <header>
    <div class="header-content">
      <img src="logo1.png" alt="Boxed Estates Logo" class="logo">
      <h1>Boxed Estates</h1>
      <h2>Think inside the box for your luxury living experience</h2>
    </div>
    <nav>
      <?php
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

      if (isset($_SESSION["user_id"])) {
        // If the user is logged in
        echo '
          <a href="index.php">Home</a>
          <a href="' . ($_SESSION["user_type"] == "buyer" ? "buyer_dashboard.php" : ($_SESSION["user_type"] == "seller" ? "seller_dashboard.php" : "admin_dashboard.html")) . '">Dashboard</a>
          <a href="logout.php">Logout</a>
        ';
      } else {
        // If the user is not logged in
        echo '
          <a href="index.php">Home</a>
          <a href="register.html">Register</a>
          <a href="login.html">Login</a>
        ';
      }
      ?>
    </nav>
  </header>
  
  <main>
    <section>
      <h2>About Our Project</h2>
      <p>At Boxed Estates, we're passionate about providing our clients with the latest in luxury living experiences. We believe that everyone deserves to live in a beautiful and comfortable home, and we're committed to helping our clients find the perfect property to call their own.<br>
        <br>
        Our team of expert real estate agents has years of experience in the industry and can help you navigate the often complex world of real estate. Whether you're a first-time buyer or an experienced investor, we'll work with you to understand your unique needs and find the perfect property to match.<br>
        <br>
        At Boxed Estates, we're not just a real estate company. We're a community of people who are passionate about helping others achieve their dreams. We believe that the right home can change your life, and we're committed to making that dream a reality for each and every one of our clients.<br>
        <br>
        So if you're looking for a new home, whether it's a cozy starter home or a luxurious estate, we're here to help. Contact us today to learn more about our services and how we can help you find the perfect property to call your own.</p>
    </section>
  
    <section>
      <h2>Our Services</h2>
      <ul>
        <li>Property Listings: We maintain a database of the latest properties available on the market, including single-family homes, townhouses, condos, and more. Our listings are updated regularly to ensure that our clients have access to the latest information.</li>
        <li>Property Valuation: If you're looking to sell your home, we can help you determine its value and price it competitively. Our team of experienced real estate agents will analyze the local market and use their expertise to provide an accurate valuation.</li>
        <li>Home Buying Assistance: Whether you're a first-time buyer or an experienced investor, we'll work with you to understand your unique needs and help you find the perfect property to match. We'll guide you through the entire buying process, from finding the right property to negotiating the best price.</li>
        <li>Investment Properties: For investors, we offer a range of investment properties, including fixer-uppers, rental properties, and more. We'll help you identify the best properties for your investment goals and work with you to maximize your return on investment.</li>
        <li>Home Staging: If you're selling your home, we offer home staging services to help make your property more appealing to potential buyers. Our team of professional home stagers will work with you to create a warm and welcoming environment that showcases your home's best features.</li>
        <li>Financing Assistance: We work with a variety of lenders to help our clients find the best financing options available. We'll help you find the right loan program to match your needs, whether you're a first-time buyer or an experienced investor.</li>
        <li>Relocation Services: If you're relocating to a new area, we can help make the process as smooth as possible. Our team of experienced agents will provide you with the latest information about the local housing market and help you find the perfect home for your needs.</li>
        <li>Property Management: We offer property management services for landlords and property owners, including tenant screening, rent collection, maintenance and repairs, and more. We'll help you maximize your rental income and keep your property in top condition.</li>
        <li>Real Estate Consulting: Our team of real estate experts can provide you with the latest market research, industry insights, and strategic advice to help you make informed decisions about your real estate investments.</li>
      </ul>
    </section>
    
  
    <section>
      <h2>Why Choose Us?</h2>
      <ul>
        <li>Experience: Our team of experienced real estate agents has years of experience in the industry and can help you navigate the often complex world of real estate.</li>
        <li>Expertise: We have the knowledge and expertise to provide you with accurate valuations, sound advice, and effective marketing strategies.</li>
        <li>Client-Focused: We're committed to putting our clients first and ensuring that they have the best possible real estate experience.</li>
        <li>Community: At Boxed Estates, we're not just a real estate company. We're a community of people who are passionate about helping others achieve their dreams.</li>
        <li>Technology: We use the latest technology to provide our clients with the best possible service, including online listings, virtual tours, and 3D modeling.</li>
        <li>Personalized Service: We understand that every client is unique, and we'll work with you to develop a personalized plan that meets your specific needs and goals.</li>
        <li>Trust and Integrity: We're committed to building long-term relationships with our clients based on trust and integrity. You can count on us to provide honest advice and transparent communication.</li>
        <li>Results: Our track record speaks for itself. We've helped countless clients find their dream homes, sell their properties for top dollar, and achieve their real estate goals.</li>
      </ul>
    </section>
    
  
    <section>
      <h2>Attracting Customers</h2>
      <ul>
        <li>Competitive Pricing: We offer competitive pricing on all of our properties and services, so you can be sure you're getting the best value for your money.</li>
        <li>User-Friendly Features: Our website is designed with the user in mind, with easy-to-use search filters, detailed property descriptions, and high-quality images and videos.</li>
        <li>Luxury Cardboard: Our state-of-the-art next-generation luxury cardboard is unlike anything else on the market. It's strong, durable, and looks great, with a variety of colors and styles to choose from.</li>
        <li>Environmentally Friendly: Our cardboard homes are environmentally friendly and sustainable, with a small carbon footprint and minimal waste.</li>
        <li>Customizable Options: We offer a range of customizable options for our properties, including interior design, landscaping, and more. You can make your dream home a reality with our help.</li>
        <li>Expert Advice: Our team of experienced real estate agents is here to provide you with expert advice and guidance every step of the way. We'll help you make informed decisions about your real estate investments.</li>
        <li>Customer Support: We're committed to providing our clients with the best possible customer support, with a team of dedicated professionals available to answer your questions and address your concerns.</li>
        <li>Not Like Amazon: Our luxury cardboard homes are not like the cheap stuff you'll find on Amazon. We use only the highest-quality materials and construction methods to ensure that our homes are built to last.</li>
      </ul>
    </section>
    
  </main>
  
  <footer>
    <p>&copy; 2023 Boxed Estates. All rights reserved.</p>
  </footer>

</body>
</html>
