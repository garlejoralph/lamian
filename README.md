# Student Attendance Management System

A comprehensive student attendance management system with QR code scanning and automatic SMS notifications for parents.

## Features

### Core Features
- **QR Code Scanning**: Students scan their unique ID cards to mark attendance
- **Automatic SMS Notifications**: Instant alerts sent to parents when students arrive/leave
- **Real-time Dashboard**: Live attendance monitoring for teachers and administrators
- **Multi-role Access**: Admin, Teacher, and Student roles with appropriate permissions
- **Advanced Analytics**: Comprehensive reporting and attendance trends

### Key Components

#### 1. Student Management
- Complete CRUD operations for student records
- Automatic QR code generation for each student
- Parent contact information management
- Grade and section assignment
- Student status tracking (Active, Inactive, Graduated, Transferred)

#### 2. Attendance System
- QR code validation and duplicate prevention
- Automatic status determination (Present, Late, Absent, Early Dismissal)
- Manual attendance override for teachers
- Real-time attendance tracking
- Attendance session management

#### 3. SMS Notifications
- Customizable SMS templates
- Parent opt-out management
- SMS delivery tracking and retry mechanism
- Daily SMS limits and provider management
- Support for different attendance scenarios

#### 4. Teacher Dashboard
- Class-specific attendance monitoring
- Student attendance history
- Attendance concerns identification
- Manual attendance marking
- Export functionality for reports

#### 5. Admin Panel
- System configuration management
- User management and role assignment
- SMS provider settings
- School information management
- Comprehensive reporting tools

#### 6. Analytics & Reporting
- Daily/weekly/monthly attendance reports
- Grade-level summaries
- Student attendance trends
- Attendance concern identification
- Export to Excel/PDF functionality

## Installation

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server
- Composer (for PHP dependencies)

### Setup Instructions

1. **Database Setup**
   ```bash
   # Import the database schema
   mysql -u root -p student_attendance < database/student_attendance.sql
   ```

2. **Install Dependencies**
   ```bash
   cd student_attendance
   composer install
   ```

3. **Configure Database Connection**
   - Edit `includes/config.php` with your database credentials
   - Update connection parameters as needed

4. **Set File Permissions**
   ```bash
   chmod 755 scanner/qrcodes/
   chmod 755 ajax/
   ```

5. **Configure SMS Provider**
   - Go to Admin Panel → Settings → SMS Settings
   - Enter your SMS provider credentials
   - Test SMS functionality

6. **Access the System**
   - Open your browser and navigate to `http://localhost/student_attendance/`
   - Default admin credentials:
     - Username: `admin`
     - Password: `admin123`

## Directory Structure

```
student_attendance/
├── admin/                  # Admin panel pages
│   ├── dashboard.php       # Admin dashboard
│   ├── students.php        # Student management
│   ├── reports.php         # Analytics and reports
│   └── settings.php        # System configuration
├── teacher/               # Teacher panel pages
│   └── dashboard.php       # Teacher dashboard
├── scanner/               # Attendance scanner
│   └── index.php          # QR code scanning interface
├── ajax/                  # AJAX endpoints
│   ├── sms_attendance.php # SMS processing
│   └── recent_scans.php   # Real-time updates
├── includes/              # Core functionality
│   ├── config.php          # Database and utility functions
│   └── navbar.php         # Navigation component
├── database/              # Database schema
│   └── student_attendance.sql
├── scanner/qrcodes/        # Generated QR codes
└── vendor/                # Composer dependencies
```

## Usage

### For Students
1. Receive your QR code ID card from school administration
2. Scan your QR code at the attendance scanner
3. Receive confirmation of successful attendance marking

### For Parents
1. Ensure your mobile number is registered with the school
2. Receive instant SMS notifications when your child arrives/leaves
3. Reply STOP to any SMS to opt-out of notifications

### For Teachers
1. Login with your provided credentials
2. View real-time attendance for your assigned classes
3. Mark manual attendance adjustments
4. Monitor students with attendance concerns
5. Generate class reports

### For Administrators
1. Access the admin panel with admin credentials
2. Manage student and teacher accounts
3. Configure system settings and SMS templates
4. Generate comprehensive reports
5. Monitor system usage and statistics

## SMS Templates

The system includes customizable SMS templates for different scenarios:

- **Present**: `[School Name] Attendance Alert: {student_name} ({grade} - {section}) arrived at {time} on {date}. Status: Present. Reply STOP to unsubscribe.`
- **Late**: Includes late arrival information
- **Absent**: Sent when student doesn't check in by cutoff time
- **Early Dismissal**: Notifies when student leaves early

## Security Features

- Password hashing using PHP's password_hash()
- Session-based authentication
- Role-based access control
- SQL injection prevention with prepared statements
- XSS protection with input sanitization
- CSRF protection on forms

## API Endpoints

### Core Endpoints
- `POST /ajax/sms_attendance.php` - Process attendance and send SMS
- `POST /ajax/recent_scans.php` - Get recent attendance scans
- `POST /ajax/export_attendance.php` - Export attendance data

### Authentication
- `POST /login.php` - User authentication
- `POST /reset_password.php` - Password reset functionality

## Customization

### Adding New SMS Providers
1. Update `ajax/sms_attendance.php` with new provider integration
2. Add provider-specific configuration in admin settings
3. Test SMS functionality

### Custom Reports
1. Add new report types in `admin/reports.php`
2. Create corresponding SQL queries
3. Add chart visualization if needed

### Theme Customization
- Modify Bootstrap CSS classes in individual files
- Update color schemes in CSS variables
- Customize dashboard layouts

## Troubleshooting

### Common Issues

1. **QR Code Not Scanning**
   - Ensure camera permissions are granted
   - Check QR code image quality
   - Verify student ID exists in database

2. **SMS Not Sending**
   - Verify SMS provider credentials
   - Check daily SMS limits
   - Ensure parent phone numbers are correctly formatted

3. **Login Issues**
   - Verify database connection
   - Check user account status (must be 'Active')
   - Reset password if needed

### Error Logs
- Check PHP error logs for detailed error messages
- Review MySQL logs for database issues
- Monitor SMS provider logs for delivery failures

## Performance Optimization

- Database indexing on frequently queried columns
- Caching of report data
- Optimized SQL queries with proper joins
- AJAX-based real-time updates
- Pagination for large data sets

## Support

For technical support or questions:
1. Check the troubleshooting section above
2. Review system logs for error details
3. Contact system administrator

## License

This project is licensed under the MIT License.

## Version History

- **v1.0.0** - Initial release with core functionality
- QR code scanning and SMS notifications
- Admin and teacher dashboards
- Basic reporting capabilities
