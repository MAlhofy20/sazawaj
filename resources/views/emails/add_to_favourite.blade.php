<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $data['title'] }}</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; text-align: center; direction: rtl; background-color: #f9f4e0; width: 100%; overflow-x: hidden;">

    <!-- Header with Logo -->
    <div style="max-width: 600px; margin: auto; background-color: #fff; padding: 20px; text-align: center; border-bottom: 3px solid #ccc;">
        <img src="{{ url('' . settings('logo')) }}" alt="Sazawaj Logo" style="max-width: 200px; height: auto;">
    </div>

    <!-- Main Body -->
    <div style="max-width: 600px; margin: auto; padding: 20px; color: #333; font-size: 18px; text-align: center;">

        <!-- Part 1: Congratulations Message -->
        <div style="background-color: #fffae6; padding: 20px; border-radius: 10px; margin-bottom: 15px;">
            <h2 style="color: #d4af37; font-size: 24px;">🎉 {{ $data['body'] }} 🎉</h2>
        </div>

        <!-- Part 2: Image on Left, Info on Right -->
        <div style="background-color: white; padding: 20px; border-radius: 10px; margin-bottom: 15px; display: flex; flex-wrap: wrap; align-items: center; justify-content: center;">
            <!-- Image (50%) -->
            <div style="flex: 1; min-width: 120px; text-align: center;">
                <img src="{{ url($data['liker']->avatar) }}" alt="Membership Image" style="width: 100%; max-width: 160px; height: auto; aspect-ratio: 4/6; border-radius: 10px;">
            </div>
            <!-- Info (50%) -->
            <div style="flex: 2; min-width: 180px; padding-right: 15px;">
                <h2 style="color: #6f42c1; font-size: 20px;">بيانات المعجب</h2>
                <p style="margin: 5px 0;     text-wrap-mode: nowrap;
"><strong>الاسم:</strong> {{ $data['liker']->first_name }}</p>
                <p style="margin: 5px 0;"><strong>الجنسية:</strong> {{ $data['liker']->nationality }}</p>
                <p style="margin: 5px 0;"><strong>الإقامة:</strong> {{ $data['liker']->city?->title_ar }}</p>
                <p style="margin: 5px 0;"><strong>العمر:</strong> {{ $data['liker']->age }}</p>
            </div>
        </div>

        <!-- Part 3: Cheering Message + CTA Button -->
        <div style="background-color: #fff3cd; padding: 20px; border-radius: 10px; margin-bottom: 15px;">
            <p style="color: #856404; font-size: 18px; margin-bottom: 15px;">
                لتبادل الاعجاب ومعرفة معلومات اكثر عن المشترك، ادخل لحسابك الأن!
            </p>
            <a href="{{ $data['url'] }}" style="display: inline-block; background-color: #4CAF50; color: white; padding: 14px 30px; font-size: 18px; text-decoration: none; border-radius: 5px;">
                {{ $data['btn-text'] }}
            </a>
        </div>

    </div>

    <!-- Footer -->
    <div style="max-width: 600px; margin: auto; background-color: #b72dd2; color: white; padding: 20px; font-weight: bold; font-size: 16px; text-align: center;">
        <table role="presentation" style="width: 100%; text-align: center;">
            <tr>
                <td><a href="{{ route('contact_us', 'contact') }}" style="color: white; text-decoration: none;">📩 راسل الإدارة</a></td>
                <td><a href="{{ url('questions') }}" style="color: white; text-decoration: none;">❓ الأسئلة المتداولة</a></td>
                <td><a href="{{ route('page', 'advices') }}" style="color: white; text-decoration: none;">💡 نصائح واقتراحات</a></td>
            </tr>
            <tr>
                <td><a href="{{ route('page', 'security') }}" style="color: white; text-decoration: none;">⚠️ تحذيرات الأمان</a></td>
                <td><a href="{{ route('page', 'condition') }}" style="color: white; text-decoration: none;">📜 شروط الاستخدام</a></td>
                <td><a href="{{ route('page', 'privacy') }}" style="color: white; text-decoration: none;">🔒 سياسة الخصوصية</a></td>
            </tr>
            <tr>
                <td colspan="3"><a href="{{ url('media-center/news') }}" style="color: white; text-decoration: none;">📰 المدونة</a></td>
            </tr>
        </table>
        <br>
        إذا كنت بحاجة إلى أي مساعدة، لا تتردد في مراسلتنا.<br>
        &copy; 2025 جميع الحقوق محفوظة - سعودي زواج
    </div>

</body>
</html>
