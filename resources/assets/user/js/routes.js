const Dashboard = () => import('./components/dashboard/index');
const Profile = () => import('./components/profile/index');
const Company = () => import('./components/company/index');
const CompanyCreate = () => import('./components/company/create');
const CompanyEdit = () => import('./components/company/edit');
const CompanyAttachment = () => import('./components/company/attachment');
const CompanyReview = () => import('./components/company/review');
const CompanyWorkSample = () => import('./components/company/work-sample');
const CompanyMember = () => import('./components/company/member');
const CompanyReservedProject = () => import('./components/company/project/detail-reserved-project');
const CompanyReservedProjectIndex = () => import('./components/company/project/index-reserved-project');
const CompanyProject = () => import('./components/company/project/detail-project');
const CompanyProjectIndex = () => import('./components/company/project/index-project');
const CompanyProjectCreate = () => import('./components/company/project/create-project');
const CompanyProjectEdit = () => import('./components/company/project/edit-project');

export default [
    {path: '/dashboard', name: 'داشبورد', component: Dashboard},
    {path: '/profile', name: 'پروفایل', component: Profile},
    {path: '/companies', name: 'شرکت ها', component: Company},
    {path: '/companies/create', name: 'ثبت شرکت جدید', component: CompanyCreate},
    {path: '/companies/:id/edit', name: 'ویرایش شرکت', component: CompanyEdit},
    {path: '/companies/:id/attachment', name: 'مدارک', component: CompanyAttachment},
    {path: '/companies/:id/review', name: 'ارزیابی', component: CompanyReview},
    {path: '/companies/:id/work-sample', name: 'نمونه کارها', component: CompanyWorkSample},
    {path: '/companies/:id/member', name: 'اعضا', component: CompanyMember},
    {path: '/companies/:id/reserved-project', name: 'پروژه های دریافتی', component: CompanyReservedProjectIndex},
    {path: '/companies/:id/project', name: 'پروژه های ارسالی', component: CompanyProjectIndex},
    {path: '/companies/:id/project/:pid/detail', name: 'جزییات پروژه', component: CompanyProject},
    {path: '/companies/:id/reserved-project/:pid/detail', name: 'جزییات پروژه', component: CompanyReservedProject},
    {path: '/companies/:id/project/create', name: 'ایجاد پروژه', component: CompanyProjectCreate},
    {path: '/companies/:id/project/:pid/edit', name: 'ویرایش پروژه', component: CompanyProjectEdit},








    {path:'*',component:{template:'<h4 class="text-center alert alert-danger">صفحه مورد نظر یافت نشد.</h4>'}}
]
