<template>
  <div>
    <header class="header">
      <div class="top-bar">
        <span>Địa chỉ: Tầng 1, Số 152 Xã Đàn - Đống Đa - Hà Nội</span>
        <span>Hotline: 024.367.XXX.XX - 082.999.XXXX</span>
      </div>
      <div class="logo-nav">
        <img src="/image/logo1.png" alt="" style="mix-blend-mode: multiply" />
        <nav>
          <ul>
            <li><a href="/homepage">Trang chủ</a></li>
            <li><a href="/gioithieu">Giới thiệu</a></li>
            <li><a href="#">Dịch vụ chính</a></li>
            <li><a href="#">Tin tức</a></li>
            <li><a href="#">Liên hệ</a></li>
            <li><a href="/appointments/create" class="btn-dk">Đăng ký khám</a></li>
            <!-- Đăng nhập / Đăng xuất xử lý trong blade hoặc frontend auth -->
          </ul>
        </nav>
      </div>
    </header>

    <section class="hero">
      <img src="/image/slider1.png" alt="Banner chính" width="100%" />
      <h2>Chung tay cùng cộng đồng đẩy lùi dịch Sars-CoV-2</h2>
    </section>

    <section class="services">
      <h2>Dịch vụ của chúng tôi</h2>
      <p>Phòng tiêm của chúng tôi cung cấp tất cả các loại dịch vụ</p>
      <div class="service-cards">
        <div class="card" v-for="(svc, index) in services" :key="index">
          <img :src="svc.img" :alt="svc.alt" />
          <h3>{{ svc.title }}</h3>
          <a href="#">Xem ngay <span>➜</span></a>
        </div>
      </div>
    </section>

    <section class="about-section">
      <div class="about-text">
        <h2>Giới thiệu về chúng tôi</h2>
        <p>
          Phòng khám đa khoa chúng tôi cung cấp dịch vụ chăm sóc sức khỏe chất lượng cao,
          hiện đại, với hệ thống quản lý bằng phần mềm tiên tiến.
        </p>
        <img src="/image/about.png" alt="Giới thiệu" />
      </div>
      <div class="about-stats">
        <div class="stat-box stat-green">05+<br />Đa dạng độ tuổi</div>
        <div class="stat-box stat-orange">100%<br />Chứng nhận quốc tế</div>
        <div class="stat-box stat-red">100%<br />Quản lý phần mềm</div>
      </div>
    </section>

    <section class="doctors-section">
      <h2>Đội ngũ bác sĩ chuyên khoa</h2>
      <p>
        Bác sĩ nhiều kinh nghiệm từng làm tại các bệnh viện lớn như Phụ sản TW, Hà Nội, Thanh Nhàn...
      </p>
      <div class="doctor-cards">
        <div class="doctor-card" v-for="(doc, index) in doctors" :key="index">
          <img :src="doc.img" :alt="doc.name" />
          <div class="info">
            <h3>{{ doc.name }}</h3>
            <p>{{ doc.title }}</p>
            <button>ĐẶT LỊCH HẸN</button>
          </div>
        </div>
      </div>
    </section>

    <footer class="footer">
      <p>&copy; 2025 Phòng Khám Đa Khoa Quốc Tế Hà Nội. All rights reserved.</p>
    </footer>
  </div>
</template>

<script>
export default {
  name: "HomepageComponent",
  data() {
    return {
      services: [
        {
          img: "/image/img1.jpg",
          alt: "Vaccine 4-6 tuổi",
          title: "Gói vắc xin cho trẻ trước khi đi học (4-6 tuổi)",
        },
        {
          img: "/image/img2.jpg",
          alt: "Vaccine 9-18 tuổi",
          title: "Gói vắc xin cho trẻ vị thành niên (9-18 tuổi)",
        },
        {
          img: "/image/img3.png",
          alt: "Vaccine sơ sinh",
          title: "Gói vắc xin cho trẻ sơ sinh",
        },
        {
          img: "/image/img4.png",
          alt: "Vaccine thai kỳ",
          title: "Gói vắc xin cho phụ nữ mang thai",
        },
      ],
      doctors: [
        {
          img: "/image/bs1.png",
          name: "BS. TRẦN THÚY VÂN",
          title: "CK I - SẢN PHỤ KHOA",
        },
        {
          img: "/image/bs2.png",
          name: "BS. TẠ THỊ HỒNG DUYÊN",
          title: "CK I - SẢN PHỤ KHOA",
        },
        {
          img: "/image/bs3.png",
          name: "BS. NGUYỄN THỊ THU HIỀN",
          title: "CK I - SẢN PHỤ KHOA",
        },
      ],
    };
  },
};
</script>

<style scoped>
/* Bạn có thể thêm các style tương ứng ở đây hoặc dùng file CSS chung */

body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    line-height: 1.6;
}

.header {
    position: fixed;
    width: 100%;
    background-color: #fff;
    border-bottom: 2px solid #e0e0e0;
  }
  
  .top-bar {
    background-color: #f7f7f7;
    padding: 8px 20px;
    font-size: 14px;
    color: #333;
    display: flex;
    justify-content: space-between;
  }
  
  .logo-nav {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 20px;
  }
  
  .logo-nav img {
    height: 80px;
    mix-blend-mode: multiply;
  }
  
  nav ul {
    list-style: none;
    display: flex;
    align-items: center;
    gap: 30px;
  }
  
  nav ul li a {
    text-decoration: none;
    font-weight: bold;
    color: #004225;
    transition: color 0.3s;
  }
  
  nav ul li a:hover {
    color: #e60000;
  }
  
  nav ul li a.btn-dk {
    background-color: #d94c6b;
    color: white;
    padding: 10px 15px;
    border-radius: 20px;
  }
  
  nav ul li a.btn-dk:hover {
    background-color: #c93b5a;
  }
.btn-dk {
    background: #ff3366;
    color: #fff !important;
    padding: 5px 10px;
    border-radius: 5px;
}

.hero {
    background: url('/images/banner.png') no-repeat center center;
    background-size: cover;
    padding: 60px 20px;
    text-align: center;
    color: #fff;
}

.services {
  text-align: center;
  padding: 50px 20px;
  background-color: #f8faff;
}

.services h2 {
  font-size: 32px;
  font-weight: bold;
  margin-bottom: 10px;
}

.services p {
  color: #666;
  margin-bottom: 40px;
  font-size: 18px;
}

.service-cards {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 30px;
}

.card {
  background: white;
  border-radius: 8px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.06);
  padding: 20px;
  max-width: 300px;
  text-align: left;
  transition: transform 0.3s;
}

.card:hover {
  transform: translateY(-5px);
}

.card img {
  width: 100%;
  border-radius: 5px;
  margin-bottom: 15px;
}

.card h3 {
  font-size: 18px;
  color: #333;
  margin-bottom: 10px;
}

.card a {
  color: #f90;
  font-weight: bold;
  text-decoration: none;
}

.card a span {
  margin-left: 5px;
}
/* Container chính */
.about-section {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    padding: 40px;
    font-family: 'Segoe UI', sans-serif;
    background: #fff;
    border-radius: 8px;
  }
  
  /* Phần mô tả bên trái */
  .about-text {
    flex: 1 1 45%;
    margin-bottom: 20px;
  }
  
  .about-text h2 {
    font-size: 26px;
    font-weight: bold;
    color: #333;
    margin-bottom: 15px;
  }
  
  .about-text p {
    font-size: 16px;
    color: #555;
    line-height: 1.6;
  }
  
  /* Phần chỉ số bên phải */
  .about-stats {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    flex: 1 1 45%;
    align-items: center;
    justify-content: space-between;
  }
  
  .stat-box {
  
    padding: 20px;
    border-radius: 10px;
    color: #fff;
    text-align: center;
    font-weight: bold;
  }
  
  .stat-blue {
    background-color: #2196f3;
  }
  
  .stat-green {
    background-color: #4caf50;
  }
  
  .stat-orange {
    background-color: #ff9800;
  }
  
  .stat-red {
    background-color: #f44336;
  }
  
  .stat-box i {
    font-size: 24px;
    display: block;
    margin-bottom: 8px;
  }
  
  /* Phần liên hệ */
  .contact-info {
    margin-top: 30px;
    font-size: 16px;
    color: #333;
    line-height: 1.5;
  }
  
  .contact-info b {
    display: block;
    margin-bottom: 8px;
  }
  
  /* Responsive */

  
.strengths {
    display: flex;
    justify-content: center;
    gap: 30px;
    margin-top: 20px;
}

.strength-item span {
    font-size: 24px;
    color: #ff3366;
    font-weight: bold;
}

.doctors-section {
    text-align: center;
    padding: 50px 20px;
    background: #f9f9f9;
    font-family: 'Segoe UI', sans-serif;
  }
  
  .doctors-section h2 {
    font-size: 28px;
    font-weight: bold;
    margin-bottom: 10px;
    color: #222;
  }
  
  .doctors-section p {
    font-size: 16px;
    color: #555;
    max-width: 800px;
    margin: 0 auto 40px;
    line-height: 1.6;
  }
  
  .doctor-cards {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    
  }
  
  .doctor-card {
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    width: 300px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
  }
  
  .doctor-card:hover {
    transform: translateY(-5px);
  }
  
  .doctor-card img {
    width: 100%;
    height: auto;
    border-bottom: 4px solid #eaeaea;
    border-radius: 50%;
    margin-top: 20px;
    width: 160px;
    height: 160px;
    object-fit: cover;
  }
  
  .info {
    background: #2e7d32;
    color: #fff;
    padding: 20px;
  }
  
  .info h3 {
    font-size: 16px;
    margin-bottom: 5px;
  }
  
  .info p {
    font-size: 14px;
    margin-bottom: 15px;
  }
  
  .info button {
    background: #e91e63;
    color: #fff;
    border: none;
    padding: 8px 14px;
    border-radius: 25px;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.3s;
  }
  
  .info button:hover {
    background: #c2185b;
  }
  .about-page {
    display: flex;
    gap: 30px;
    font-family: 'Segoe UI', sans-serif;
    padding: 30px;
    background: #fff;
    color: #333;
  }
  
  .sidebar {
    width: 260px;
  }
  
  .sidebar h3 {
    background-color: #388e3c;
    color: white;
    padding: 12px;
    border-radius: 8px 8px 0 0;
    text-align: center;
    margin-top: 125px;
  }
  
  .sidebar ul {
    list-style: none;
    padding: 0;
    border: 1px solid #ccc;
    border-top: none;
    border-radius: 0 0 8px 8px;
    overflow: hidden;
  }
  
  .sidebar ul li {
    padding: 12px;
    border-bottom: 1px solid #ddd;
    background: #f8f8f8;
  }
  
  .sidebar ul li:hover {
    background: #e0f2f1;
    cursor: pointer;
  }
  
  .appointment-box {
    margin-top: 30px;
    background: #fff3e0;
    padding: 15px;
    border-radius: 8px;
    text-align: center;
    border: 1px solid #ccc;
  }
  
  .appointment-box h4 {
    font-size: 16px;
    margin-bottom: 10px;
    background: #795548;
    color: white;
    padding: 8px;
    border-radius: 4px;
  }
  
  .appointment-box input,
  .appointment-box select {
    width: 100%;
    margin: 8px 0;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
  }
  
  .appointment-box button {
    background: #fbc02d;
    border: none;
    color: #000;
    padding: 10px 15px;
    font-weight: bold;
    width: 100%;
    border-radius: 4px;
    cursor: pointer;
  }
  
  .appointment-box button:hover {
    background: #f9a825;
  }
  
  .content {
    flex: 1;
  }
  
  .content h2 {
    font-size: 22px;
    font-weight: bold;
    margin-bottom: 20px;
    text-transform: uppercase;
  }
  
  .content p {
    font-size: 16px;
    line-height: 1.7;
    margin-bottom: 16px;
  }
  /* Dropdown container */
.dropdown {
    position: relative;
    display: inline-block;
}

/* Dropdown button */
.dropbtn {
    cursor: pointer;
    padding: 8px 16px;
    text-decoration: none;
    color: #333;
}

/* Dropdown content */
.dropdown-content {
    display: none;
    position: absolute;
    background-color: #ffffff;
    min-width: 235px;
    box-shadow: 0px 8px 16px rgba(0,0,0,0.1);
    z-index: 1;
    border-radius: 4px;
    text-align: right;
}

.dropdown-content a {
    color: black;
    padding: 10px 14px;
    text-decoration: none;
    display: block;
}

.dropdown-content a:hover {
    background-color: #f0f0f0;
}

/* Show dropdown on hover */
.dropdown:hover .dropdown-content {
    display: block;
}

</style>
