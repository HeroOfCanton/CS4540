using System;
using Microsoft.VisualStudio.TestTools.UnitTesting;
using OpenQA.Selenium;
using OpenQA.Selenium.Support.UI;
using OpenQA.Selenium.Firefox;
using System.Text;
using System.Text.RegularExpressions;
using System.Threading;

namespace HW9_Selenium
{
    [TestClass]
    public class UnitTest1
    {
        private IWebDriver driver;
        private StringBuilder verificationErrors;
        private string baseURL;
        private bool acceptNextAlert = true;

        [TestInitialize]
        public void SetupTest()
        {
            driver = new FirefoxDriver();
            baseURL = "http://uofu-cs4540-84.westus.cloudapp.azure.com/";
            verificationErrors = new StringBuilder();
        }

        [TestCleanup]
        public void TeardownTest()
        {
            try
            {
                driver.Quit();
            }
            catch (Exception)
            {
                // Ignore errors if unable to close the browser
            }
            Assert.AreEqual("", verificationErrors.ToString());
        }

        [TestMethod]
        public void BasicAdvisorLoginTest()
        {
            driver.Navigate().GoToUrl(baseURL);
            driver.FindElement(By.CssSelector("button.minimal-indent")).Click();
            driver.FindElement(By.LinkText("Entrance Portal")).Click();
            driver.FindElement(By.Id("login_button")).Click();
            driver.FindElement(By.Id("Login")).Clear();
            driver.FindElement(By.Id("Login")).SendKeys("rwelling");
            driver.FindElement(By.Id("password")).Clear();
            driver.FindElement(By.Id("password")).SendKeys("password");
            driver.FindElement(By.Id("saveForm")).Click();
            Assert.AreEqual("https://uofu-cs4540-84.westus.cloudapp.azure.com/Projects/Grad_Progress/Advisor/students.php?lastName=Welling", driver.Url);
        }
        [TestMethod]
        public void NotAuthTest()
        {
            driver.Navigate().GoToUrl(baseURL);
            driver.FindElement(By.CssSelector("button.minimal-indent")).Click();
            driver.FindElement(By.LinkText("Entrance Portal")).Click();
            driver.FindElement(By.LinkText("DGS Home")).Click();
            Assert.AreEqual("https://uofu-cs4540-84.westus.cloudapp.azure.com/Projects/Grad_Progress/not_auth.php", driver.Url);
        }

        [TestMethod]
        public void NewUserTest()
        {
            driver.Navigate().GoToUrl(baseURL);
            driver.FindElement(By.CssSelector("button.minimal-indent")).Click();
            driver.FindElement(By.LinkText("Entrance Portal")).Click();
            driver.FindElement(By.CssSelector("a > button.btn")).Click();
            driver.FindElement(By.Id("First_Name")).Clear();
            driver.FindElement(By.Id("First_Name")).SendKeys("Sarah");
            driver.FindElement(By.Id("Last_Name")).Clear();
            driver.FindElement(By.Id("Last_Name")).SendKeys("Vernell");
            driver.FindElement(By.Id("UID")).Clear();
            driver.FindElement(By.Id("UID")).SendKeys("7537537");
            driver.FindElement(By.Id("Login")).Clear();
            driver.FindElement(By.Id("Login")).SendKeys("svernell");
            driver.FindElement(By.Id("password1")).Clear();
            driver.FindElement(By.Id("password1")).SendKeys("password");
            driver.FindElement(By.Id("password2")).Clear();
            driver.FindElement(By.Id("password2")).SendKeys("password");
            driver.FindElement(By.Id("saveForm")).Click();
            Assert.AreEqual("Message: User Saved Successfully. User has role of Student until DGS updates.", driver.FindElement(By.CssSelector("#form_message")).Text);
        }

        [TestMethod]
        public void AddUserFormVerifyTest()
        {
            driver.Navigate().GoToUrl(baseURL);
            driver.FindElement(By.CssSelector("button.minimal-indent")).Click();
            driver.FindElement(By.LinkText("Entrance Portal")).Click();
            driver.FindElement(By.CssSelector("a > button.btn")).Click();
            driver.FindElement(By.Id("First_Name")).Clear();
            driver.FindElement(By.Id("First_Name")).SendKeys("Michael");
            driver.FindElement(By.Id("Last_Name")).Clear();
            driver.FindElement(By.Id("Last_Name")).SendKeys("Hurst");
            driver.FindElement(By.Id("UID")).Clear();
            driver.FindElement(By.Id("UID")).SendKeys("8528528");
            driver.FindElement(By.Id("Login")).Clear();
            driver.FindElement(By.Id("Login")).SendKeys("mhurst852");
            driver.FindElement(By.Id("password1")).Clear();
            driver.FindElement(By.Id("password1")).SendKeys("password");
            driver.FindElement(By.Id("password2")).Clear();
            driver.FindElement(By.Id("password2")).SendKeys("password");
            driver.FindElement(By.Id("saveForm")).Click();
            Assert.AreEqual("Message: User Saved Successfully. User has role of Student until DGS updates.", driver.FindElement(By.CssSelector("#form_message")).Text);
            driver.FindElement(By.LinkText("Entrance Portal")).Click();
            driver.FindElement(By.Id("login_button")).Click();
            driver.FindElement(By.Id("Login")).Clear();
            driver.FindElement(By.Id("Login")).SendKeys("mhurst852");
            driver.FindElement(By.Id("password")).Clear();
            driver.FindElement(By.Id("password")).SendKeys("password");
            driver.FindElement(By.Id("saveForm")).Click();
            Assert.AreEqual("https://uofu-cs4540-84.westus.cloudapp.azure.com/Projects/Grad_Progress/Student/student_forms.php", driver.Url);
            driver.FindElement(By.LinkText("Due Progress Form")).Click();
            driver.FindElement(By.Id("First_Name")).Clear();
            driver.FindElement(By.Id("First_Name")).SendKeys("Michael");
            driver.FindElement(By.Id("Last_Name")).Clear();
            driver.FindElement(By.Id("Last_Name")).SendKeys("Hurst");
            driver.FindElement(By.Id("ID")).Clear();
            driver.FindElement(By.Id("ID")).SendKeys("8528528");
            driver.FindElement(By.Id("Degree-1")).Click();
            driver.FindElement(By.Id("Track")).Clear();
            driver.FindElement(By.Id("Track")).SendKeys("Networking");
            driver.FindElement(By.Id("Year_Admit")).Clear();
            driver.FindElement(By.Id("Year_Admit")).SendKeys("2014");
            driver.FindElement(By.Id("Advisor")).Clear();
            driver.FindElement(By.Id("Advisor")).SendKeys("Welling");
            driver.FindElement(By.Id("Committee_1")).Clear();
            driver.FindElement(By.Id("Committee_1")).SendKeys("Germain");
            driver.FindElement(By.Id("Committee_2")).Clear();
            driver.FindElement(By.Id("Committee_2")).SendKeys("Parker");
            driver.FindElement(By.Id("Committee_3")).Clear();
            driver.FindElement(By.Id("Committee_3")).SendKeys("Thomas");
            driver.FindElement(By.Id("Progress")).Clear();
            driver.FindElement(By.Id("Progress")).SendKeys("Pithy");
            driver.FindElement(By.Id("date")).Clear();
            driver.FindElement(By.Id("date")).SendKeys("04/07/2016");
            driver.FindElement(By.Id("saveForm")).Click();
            driver.FindElement(By.LinkText("Your Forms")).Click();
            Assert.IsTrue(IsElementPresent(By.XPath("//td[2][.='04/07/2016']")));
            Assert.IsTrue(IsElementPresent(By.XPath("//td[3][.='Computing']")));
            Assert.IsTrue(IsElementPresent(By.XPath("//td[4][.='Networking']")));
            Assert.IsTrue(IsElementPresent(By.XPath("//td[5][.='Welling']")));
            Assert.IsTrue(IsElementPresent(By.XPath("//div[2]/div/table/tbody/tr[2]/td[.='Michael']")));
            Assert.IsTrue(IsElementPresent(By.XPath("//div[2]/div/table/tbody/tr[2]/td[2][.='Hurst']")));
            Assert.IsTrue(IsElementPresent(By.XPath("//div[2]/div/table/tbody/tr[2]/td[3][.='mhurst852']")));
            Assert.IsTrue(IsElementPresent(By.XPath("//div[2]/div/table/tbody/tr[2]/td[4][.='8528528']")));
        }

        [TestMethod]
        public void AddStudentCheckAdvisorTest()
        {
            driver.Navigate().GoToUrl(baseURL);
            driver.FindElement(By.CssSelector("button.minimal-indent")).Click();
            driver.FindElement(By.LinkText("Entrance Portal")).Click();
            driver.FindElement(By.Id("login_button")).Click();
            driver.FindElement(By.Id("Login")).Clear();
            driver.FindElement(By.Id("Login")).SendKeys("rwelling");
            driver.FindElement(By.Id("password")).Clear();
            driver.FindElement(By.Id("password")).SendKeys("password");
            driver.FindElement(By.Id("saveForm")).Click();
            Assert.IsTrue(IsElementPresent(By.XPath("//div[@id='student_list']/table/tbody/tr[6]/td[.='Michael Hurst']")));
        }

        private bool IsElementPresent(By by)
        {
            try
            {
                driver.FindElement(by);
                return true;
            }
            catch (NoSuchElementException)
            {
                return false;
            }
        }

        private bool IsAlertPresent()
        {
            try
            {
                driver.SwitchTo().Alert();
                return true;
            }
            catch (NoAlertPresentException)
            {
                return false;
            }
        }

        private string CloseAlertAndGetItsText()
        {
            try
            {
                IAlert alert = driver.SwitchTo().Alert();
                string alertText = alert.Text;
                if (acceptNextAlert)
                {
                    alert.Accept();
                }
                else
                {
                    alert.Dismiss();
                }
                return alertText;
            }
            finally
            {
                acceptNextAlert = true;
            }
        }
    }
}
